<?php

namespace Consilience\Starling\Payments\Response;

/**
 * A mandate that allows a specific originator to claim direct debit payments.
 */

use Consilience\Starling\Payments\Response\Models\BacsOriginator;
use Consilience\Starling\Payments\AbstractResponse;

class DirectDebitMandate extends AbstractResponse
{
    /**
     * @var string UUID
     * Unique identifier of the company requesting or receiving the payment.
     */
    protected $paymentBusinessUid;

    /**
     * @var string UUID
     * Unique identifier of the account containing the funds sent or received.
     */
    protected $paymentAccountUid;

    /**
     * @var string UUID
     * Unique identifier of the payment account address.
     */
    protected $addressUid;

    /**
     * @var string UUID
     * Unique identifier of the BACS mandate.
     */
    protected $mandateUid;

    /**
     * @var string one of static::DIRECT_DEBIT_STATUS_*
     * Status of the direct debit mandate.
     */
    protected $reference;

    /**
     * @var BacsOriginator
     */
    protected $bacsOriginator;

    /**
     * @var string one of static::DIRECT_DEBIT_STATUS_*
     * Status of the direct debit mandate.
     */
    protected $status;

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setBacsOriginator(array $data)
    {
        $this->bacsOriginator = BacsOriginator::fromArray($data);
    }

    /**
     * @return bool true if the account address is active.
     */
    public function isActive()
    {
        return $this->status === static::DIRECT_DEBIT_STATUS_ACTIVE;
    }
}
