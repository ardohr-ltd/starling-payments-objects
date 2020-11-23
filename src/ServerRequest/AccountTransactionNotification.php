<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 * Notification for a credit or deduction transaction applied directly
 * to an account, rather than through an address on a payment scheme.
 */

use Consilience\Starling\Payments\AbstractServerRequest;

use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\PaymentReturnDetails;
use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;
use Consilience\Starling\Payments\Response\Models\PaymentDetailsAccount;
use Consilience\Starling\Payments\Response\Models\PaymentRejectionReason;

class AccountTransactionNotification extends AbstractServerRequest
{
    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
    // phpcs:ignore
    protected $_webhookType = AbstractServerRequest::WEBHOOK_TYPE_ACCOUNT_TRANSACTION;

    /**
     * @var string UUID
     * Unique identifier of the notification.
     */
    protected $notificationUid;

    /**
     * @var string UUID
     * Unique identifier of the account transaction applied.
     */
    protected $accountTransactionUid;

    /**
     * @var string UUID
     * Unique identifier of the account the funds were applied to.
     */
    protected $paymentAccountUid;

    /**
     * @var string one of static::SOURCE_*
     * Scheme through which the funds were sent or received.
     */
    protected $source;

    /**
     * @var CurrencyAndAmount
     */
    protected $currencyAndAmount;

    /**
     * @var string
     * The reference associated with the transaction.
     */
    protected $reference;

    /**
     * @var string one of static::DIRECTION_*
     * Indicates whether the transaction is inbound or outbound.
     */
    protected $direction;

    /**
     * @var string date-time format 2017-06-05T11:47:58.801Z
     * The time at which Starling Bank applied the transaction to the account balance.
     */
    protected $transactionTime;

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setCurrencyAndAmount(array $data)
    {
        $this->currencyAndAmount = CurrencyAndAmount::fromArray($data);
    }

    /**
     * @return Carbon the timestamp as a Carbon object, with timezone preserved.
     * Timestamp of the transactionTime from the scheme.
     */
    public function getTransactionTimeCarbon()
    {
        return Carbon::parse($this->transactionTime);
    }

    /**
     * Other endpoints use the shorter `paymentUid`, so we provide this alias.
     */
    public function getAccountUid()
    {
        return $this->getProperty('paymentAccountUid');
    }
}
