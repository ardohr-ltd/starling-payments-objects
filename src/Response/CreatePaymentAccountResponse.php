<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Retrieved payment account details.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\Response\Models\ErrorDetail;
use Consilience\Starling\Payments\Response\Collections\ErrorDetailCollection;

class CreatePaymentAccountResponse implements \JsonSerializable
{
    use HydratableTrait;

    /**
     * @var string UUID
     * Unique identifier of the payment account.
     */
    protected $paymentAccountUid;

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
