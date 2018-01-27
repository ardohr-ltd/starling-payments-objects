<?php

namespace Consilience\Starling\Payments;

/**
 *
 */

use UnexpectedValueException;
use Exception;

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
        $this->setFromArray($data);
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
                'Data item "%s" does not have a matching property in class %s.',
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
     * Set properties from array data.
     *
     * @param array $data
     */
    protected function setFromArray(array $data = [])
    {
        foreach ($data as $name => $value) {
            $this->setProperty($name, $value);
        }
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
     * Get the value of a property, using a getter if one exists.
     *
     * @param string $name the name of the property in lower camelCase
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

        return $value !== null;
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
}
