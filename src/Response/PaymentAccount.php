<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Retrieved payment account details.
 */

use Consilience\Starling\Payments\AbstractResponse;
use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\Balance;

class PaymentAccount extends AbstractResponse
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
    protected $accountUid;

    /**
     * @var string one of static::ACCOUNT_HOLDER_*
     * Type of the account holder, currently only AGENCY is supported.
     */
    protected $accountHolder;

    /**
     * @var string date-time e.g. 2017-06-05T11:47:58.801Z
     * Date and time the account was first created.
     */
    protected $createdAt;

    /**
     * @var string
     * Description of the account, for reference.
     */
    protected $description;

    /**
     * @var Balance
     * Account balance and direction.
     */
    protected $balance;

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setBalance(array $data)
    {
        $this->balance = Balance::fromArray($data);
    }

    /**
     * @return Carbon the createdAt as a Carbon object, with timezone preserved.
     */
    public function getCreatedAtCarbon()
    {
        return Carbon::parse($this->createdAt);
    }
}
