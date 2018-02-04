<?php

namespace Consilience\Starling\Payments;

/**
 * A response that has a "success" boolean and an optional array of errorDetrails.
 */

use UnexpectedValueException;
use ReflectionClass;

use Consilience\Starling\Payments\Response\Collections\ErrorDetailCollection;

trait HasErrorsTrait
{
    /**
     * @var bool
     * True if the method completed successfully
     */
    protected $success;

    /**
     * @var collection of ErrorDetail
     */
    protected $errors;

    /**
     * @return bool true if the payment account was created successfuly
     */
    public function isSuccess()
    {
        // Assume it is a success if not explicitlty told either way.

        return $this->success === true || $this->success === null;
    }

    /**
     * The errors will be a collection.
     */
    protected function setErrors(array $value)
    {
        $this->errors = new ErrorDetailCollection($value);
    }

    public function getErrorCount()
    {
        return $this->errors ? $this->errors->count() : 0;
    }
}
