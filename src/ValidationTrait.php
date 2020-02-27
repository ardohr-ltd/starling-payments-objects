<?php

namespace Consilience\Starling\Payments;

/**
 * Some helper methods for validating data use to construct requests.
 */

use UnexpectedValueException;
use ReflectionClass;

use Money\Currencies\ISOCurrencies;
use Money\Currency;

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
     * @param string $pattern regular expression (preg) to validate against
     * @throws UnexpectedValueException
     */
    public function assertString($value, $minLength = 0, $maxLength = null, $pattern = null)
    {
        if (! is_string($value)) {
            throw new UnexpectedValueException(sprintf(
                'Value must be a string; %s given',
                gettype($value)
            ));
        }

        if ($minLength !== null && strlen($value) < $minLength) {
            throw new UnexpectedValueException(sprintf(
                'Minimum length of string is %d; actual length is %d',
                $minLength,
                strlen($value)
            ));
        }

        if ($maxLength !== null && strlen($value) > $maxLength) {
            throw new UnexpectedValueException(sprintf(
                'Maximum length of string is %d; actual length is %d',
                $maxLength,
                strlen($value)
            ));
        }

        if ($pattern !== null && ! preg_match($pattern, $value)) {
            throw new UnexpectedValueException(sprintf(
                'String "%s" fails regular expression check "%s"',
                $value,
                $pattern
            ));
        }
    }

    /**
     * A page number is a positive integer, 1 or higher.
     *
     * @value mixed the value being checked
     * @throws UnexpectedValueException
     */
    public function assertPageNumber($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            throw new UnexpectedValueException(sprintf(
                'Page number must be an intege; "%s" is not',
                (string)$value
            ));
        }

        if (intval($value) < 1) {
            throw new UnexpectedValueException(sprintf(
                'Page number must be 1 or more; %d is not',
                intval($value)
            ));
        }
    }

    /**
     * Assert a money minor unit (integer).
     *
     * @value mixed the value being checked
     * @throws UnexpectedValueException
     */
    public function assertMinorUnit($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            throw new UnexpectedValueException(sprintf(
                'Money Minor Unit must be an intege; "%s" is not',
                (string)$value
            ));
        }
    }

    /**
     * Assert value is a three-digit ISO 4217 currency code.
     *
     * @value mixed the value being checked
     * @throws UnexpectedValueException
     */
    public function assertCurrencyCode($value)
    {
        $iso = new ISOCurrencies();
        $currency = new Currency($value);

        if (! $iso->contains($currency)) {
            throw new UnexpectedValueException(sprintf(
                'The code "%s" is not a valid currency code',
                (string)$value
            ));
        }
    }

    /**
     * Match a UUID, e.g. "07474ac3-ca1c-4407-929f-a980e5f25590"
     */
    public function assertUid($value)
    {
        return $this->assertString(
            $value,
            36,
            36,
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/'
        );
    }

    /**
     * Domestic sort code.
     */
    public function assertSortCode($value)
    {
        return $this->assertString(
            $value,
            static::SORT_CODE_MIN_LENGTH,
            static::SORT_CODE_MAX_LENGTH,
            '/^\d{6}$/'
        );
    }

    /**
     * Domestic account number.
     */
    public function assertAccountNumber($value)
    {
        $this->assertString(
            $value,
            static::ACCOUNT_NUMBER_MIN_LENGTH,
            static::ACCOUNT_NUMBER_MAX_LENGTH,
            '/^\d{8}$/'
        );
    }

    /**
     * A payment reference.
     * Pattern: [a-zA-Z0-9-/?:().+#=!%&*<>;{@ "']{1,18}
     */
    public function assertReference($value)
    {
        $this->assertString(
            $value,
            static::REFERENCE_MIN_LENGTH,
            static::REFERENCE_MAX_LENGTH,
            '/^[a-zA-Z0-9\/' . preg_quote('-?:().,+#=!%&*<>;{@ "\'') . ']'
                . '{'.static::REFERENCE_MIN_LENGTH.','.static::REFERENCE_MAX_LENGTH.'}$/'
        );
    }

    /**
     * A payment additional remittance information.
     *
     * CHECKME: this looks wrong. The FPS scheme allows newline characters, so
     * these must be taken into account. However, Starling seems to reject newlines
     * when sending a payment, though can *receive* newlines in inbound domestic
     * payments from other banks.
     *
     * Pattern: [a-zA-Z0-9-/?:().,+#=!%&*<>;{@ "']{0,140}
     */
    public function assertAdditionalRemittanceInformation($value)
    {
        $this->assertString(
            $value,
            static::ADDITIONAL_REMITTANCE_INFORMATION_MIN_LENGTH,
            static::ADDITIONAL_REMITTANCE_INFORMATION_MAX_LENGTH,
            '/^[a-zA-Z0-9\/' . preg_quote('-?:().,+#=!%&*<>;{@ "\'') . ']'
                . '{'.static::ADDITIONAL_REMITTANCE_INFORMATION_MIN_LENGTH
                . ','.static::ADDITIONAL_REMITTANCE_INFORMATION_MAX_LENGTH.'}$/'
        );
    }

    /**
     * A payment reference.
     * Pattern: [a-zA-Z0-9-/?:().+#=!%&*<>;{@ "']{0,140}
     */
    public function assertAdditionalRemittanceInformation($value)
    {
        if ($value !== null) {
            $this->assertString(
                $value,
                static::REFERENCE_MIN_LENGTH,
                static::REFERENCE_MAX_LENGTH,
                '/^[a-zA-Z0-9\/' . preg_quote('-?:().+#=!%&*<>;{@ "\'') . ']{0,140}$/'
            );
        }
    }
}
