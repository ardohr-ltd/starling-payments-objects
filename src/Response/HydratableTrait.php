<?php

namespace Consilience\Starling\Payments\Response;

/**
 *
 */

trait HydratableTrait
{
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

        if (! $this->_hydratableIsSet) {
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
}
