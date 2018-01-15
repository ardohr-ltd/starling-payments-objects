<?php

namespace Consilience\Starling\Payments;

/**
 *
 */

use UnexpectedValueException;
use ReflectionClass;

trait HydratableTrait
{
    /**
     * @var bool true if any properties have been set.
     */
    // phpcs:ignore
    protected $_hydratableIsSet = false;

    /**
     * Constructed with an array.
     * Each array element feeds into a property or setter method.
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $name => $value) {
            $this->setProperty($name, $value);
        }
    }

    /**
     * @return bool true if the object has not been instantiated with any data
     */
    public function isEmpty()
    {
        return ! $this->_hydratableIsSet;
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
            throw new \Exception(sprintf(
                'Data item "%s" does not have a matching property in clsss %s.',
                $name,
                __CLASS__
            ));
        }

        if (! $this->_hydratableIsSet && $value !== null) {
            $this->_hydratableIsSet = true;
        }
    }

    /**
     * Instantiate the object and populate/hydrate from nested array data.
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data)
    {
        return new static($data);
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

        throw new \Exception(sprintf(
            'Property "%s" does not exist in clsss %s.',
            $name,
            __CLASS__
        ));
    }

    /**
     * Get the value of a property, using a getter if one exists.
     */
    public function __get($name)
    {
        return $this->getProperty($name);
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

        // Exclude any properties with a name that starts with an undersore.

        $properties = array_filter(
            $properties,
            function ($key) {
                return strpos($key, '_') !== 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        return $properties;
    }

    /**
     * Get an array of constants in this [late-bound] class, with an optional prefix.
     * @param null $prefix
     * @return array
     */
    public function constantList($prefix = null)
    {
        $reflection = new ReflectionClass(get_called_class());
        $constants = $reflection->getConstants();

        if (isset($prefix)) {
            $result = [];
            $prefix = strtoupper($prefix);
            foreach ($constants as $key => $value) {
                if (strpos($key, $prefix) === 0) {
                    $result[$key] = $value;
                }
            }
            return $result;
        } else {
            return $constants;
        }
    }

    /**
     * Get a class constant value based on suffix and prefix.
     * Returns null if not found.
     * TODO: map camelCase suffic to UPPER_SNAKE_CASE
     *
     * @param $prefix
     * @param $suffix
     * @return mixed|null
     */
    public function constantValue($prefix, $suffix)
    {
        $name = strtoupper($prefix . '_' . $suffix);

        if (defined("static::$name")) {
            return constant("static::$name");
        }

        return null;
    }

    /**
     * Asserts a value is in the list of constants provides by the prefix.
     */
    public function assertInConstantList($prefix, $value)
    {
        if (! is_string($value)) {
            throw new UnexpectedValueException(sprintf(
                'Value must be a string; %s given',
                gettype($value)
            ));
        }

        if (! in_array($value, $this->constantList($prefix))) {
            throw new UnexpectedValueException(sprintf(
                'Value "%s" not defined as constant "%s*"',
                $value,
                $prefix
            ));
        }
    }
}
