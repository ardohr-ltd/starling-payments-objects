<?php

namespace Consilience\Starling\Payments;

/**
 *
 */

use UnexpectedValueException;
use Exception;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

trait HydratableTrait
{
    /**
     * @var bool true if any properties have been set.
     */
    // phpcs:ignore
    protected $_hydratableIsSet = false;

    /**
     * @var bool true to throw an exception when accessing unrecognised properties.
     */
    // phpcs:ignore
    protected $_exceptionOnInvalidProperty = false;

    /**
     * @var array somewhere to put properties we doe not support.
     */
    // phpcs:ignore
    protected $_additionalProperties = [];

    /**
     * @var array the original array used to instantiate this object.
     */
    // phpcs:ignore
    protected $_rawData = [];

    /**
     * Constructed with an array.
     * Each array element feeds into a property or setter method.
     */
    public function __construct(array $data = [])
    {
        $this->setFromArray($data);
    }

    public function hasValues()
    {
        return $this->_hydratableIsSet;
    }

    /**
     * @return bool true if the object has not been instantiated with any data
     */
    public function isEmpty()
    {
        return ! $this->hasValues();
    }

    /**
     * Set a property by name, using a setter if it exists or the
     * property directly if there is no setter.
     *
     * @param string $name the name of the property in lower camelCase
     * @param mixed $value the value to put into the property
     */
    protected function setProperty($name, $value)
    {
        $setFunction = 'set' . ucfirst($name);

        if (method_exists($this, $setFunction)) {
            $this->$setFunction($value);
        } elseif (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            if ($this->_exceptionOnInvalidProperty) {
                throw new InvalidArgumentException(sprintf(
                    'Data item "%s" does not have a matching property in class %s.',
                    $name,
                    __CLASS__
                ));
            }

            $this->_additionalProperties[$name] = $value;
        }

        // If the value is not null, then the object is set; mark it as set.

        if (! $this->_hydratableIsSet && $value !== null) {
            $this->_hydratableIsSet = true;
        }
    }

    /**
     * Clone $this with a new property set.
     */
    public function withProperty($name, $value)
    {
        $clone = clone $this;
        $clone->setProperty($name, $value);
        return $clone;
    }

    /**
     * Instantiate the object and populate/hydrate from nested array data.
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data)
    {
        $instance = new static($data);
        $instance = $instance->withProperty('rawData', $data);
        return $instance;
    }

    /**
     * Set properties from array data.
     *
     * @param array $data
     */
    protected function setFromArray(array $data = [])
    {
        foreach ($data as $name => $value) {
            $this->setProperty($name, $value);
        }

        $this->setProperty('rawData', $data);
    }

    /**
     * Get the value of a property, using a getter if one exists.
     *
     * @param string $name the name of the property in lower camelCase
     * @return mixed
     */
    public function getProperty($name)
    {
        // Check if trying to access a protected property.

        if (strpos('_', $name) === false) {
            $getFunction = 'get' . ucfirst($name);

            if (method_exists($this, $getFunction)) {
                return $this->$getFunction();
            }

            if (property_exists($this, $name)) {
                return $this->$name;
            }
        }

        if ($this->_exceptionOnInvalidProperty) {
            throw new InvalidArgumentException(sprintf(
                'Property "%s" does not exist in class %s.',
                $name,
                __CLASS__
            ));
        }

        if (array_key_exists($name, $this->_additionalProperties)) {
            return $this->_additionalProperties[$name];
        }
    }

    /**
     * Return any unsupported/unrecognised properties that have been pushed
     * into the model. This can be used to monitor additions to the published
     * Starling Payments API.
     * These are properties not yet supported by this package.
     *
     * @return array
     */
    public function getUnsupportedProperties()
    {
        return $this->_additionalProperties;
    }

    /**
     * Get the value of a property, using a getter if one exists.
     */
    public function __get($name)
    {
        return $this->getProperty($name);
    }

    /**
     * Get the value of a property, using a getter if one exists.
     *
     * @param string $name the name of the property in lowerCamelCase
     * @return mixed
     */
    public function hasProperty($name)
    {
        // We don't want to throw exceptions on just checking if a
        // property exists.

        try {
            $value = $this->getProperty($name);
        } catch (Exception $e) {
            $value = null;
        }

        return $value !== null && $value !== [];
    }

    /**
     * For JSON serialization (for storing and logging), the properties
     * are returned here in order. Any properties starting with an underscoe
     * are considered internal to the functioning of the class and not
     * serializable data.
     *
     * All response messages and models must implement \JsonSerializable for
     * this to work.
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        // Start with all properties.

        $properties = get_object_vars($this);

        // Put the fields into the correct order if necessary.

        if (! empty($this->_fieldOrder)) {
            $properties = array_merge(array_flip($this->_fieldOrder), $properties);
        }

        // Exclude any properties with a name that starts with an undersore
        // or that has a null value.

        $properties = array_filter(
            $properties,
            function ($value, $key) {
                return strpos($key, '_') !== 0 && $value !== null;
            },
            ARRAY_FILTER_USE_BOTH
        );

        return $properties;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }

    /**
     * Instantiate from a PSR-7 response.
     */
    public static function fromResponse(ResponseInterface $response)
    {
        // We can only deal with JSON response bodies.

        if ($response->getHeaderLine('Content-Type') === 'application/json') {
            $bodyData = json_decode((string)$response->getBody(), true);
            $model = new static($bodyData ?: []);
        } else {
            // We didn't get a JSON response, so must dig deeper into the response
            // to see if we can build an error detail.
            $model = new static([]);
        }

        // Move any HTTP errors into the errors stack and reset the success flag.

        $statusCode = $response->getStatusCode();
        $statusClass = (int) floor($statusCode / 100);
        $reasonPhrase = $response->getReasonPhrase();

        if ($statusClass !== 2) {
            $model = $model->withProperty('success', false);

            // Add an error message with the HTTP details.
            // Only do this if there are not already erros delivered from the remote host.

            if ($model->getErrorCount() === 0) {
                $model = $model->withProperty(
                    'errors',
                    [
                        ['message' => sprintf('%d: %s', $statusCode, $reasonPhrase)],
                    ]
                );
            }
        }

        return $model;
    }

    /**
     * @param array $data the original array used to instantiate
     */
    protected function setRawData(array $data)
    {
        $this->_rawData = $data;
    }

    /**
     * @return array
     */
    protected function getRawData()
    {
        return $this->_rawData;
    }
}
