<?php

namespace Consilience\Starling\Payments;

/**
 * Some helper methods for validating data use to construct requests.
 */

use UnexpectedValueException;
use ReflectionClass;

trait ValidationTrait
{
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

    /**
     * Assert a value is a string, optionally within a length array.
     *
     * @value mixed the value being checked
     * @param int $minLegth
     * @param int $maxLegth null for no check
     * @throws UnexpectedValueException
     */
    public function assertString($value, $minLength = 0, $maxLength = null)
    {
        if (! is_string($value)) {
            throw new UnexpectedValueException(sprintf(
                'Value must be a string; %s given',
                gettype($value)
            ));
        }

        if ($minLength !== null && strlen($value) < $minLength) {
            throw new UnexpectedValueException(sprintf(
                'Minimum length of string is %d; %d givem',
                $minLength,
                strlen($value)
            ));
        }

        if ($maxLength !== null && strlen($value) > $maxLength) {
            throw new UnexpectedValueException(sprintf(
                'Maximum length of string is %d; %d givem',
                $maxLength,
                strlen($value)
            ));
        }
    }
}
