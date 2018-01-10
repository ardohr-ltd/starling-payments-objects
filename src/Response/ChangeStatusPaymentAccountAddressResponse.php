<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Response to a request to change the status of a payment account address.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\Response\Models\ErrorDetail;
use Consilience\Starling\Payments\Response\Collections\ErrorDetailCollection;

class ChangeStatusPaymentAccountAddressResponse implements \JsonSerializable
{
    use HydratableTrait;

    /**
     * @var string UUID
     * Unique identifier of the payment account address.
     */
    protected $addressUid;

    /**
     * @var bool
     * True if the method completed successfully.
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
        return (bool)($this->success);
    }

    /**
     * The errors will be a collection.
     */
    protected function setErrors(array $value)
    {
        $errorDetailCollection = new ErrorDetailCollection();

        foreach($value as $errorDetailData) {
            $errorDetailCollection->push(new ErrorDetail($errorDetailData));
        }

        $this->errors = $errorDetailCollection;
    }
}
