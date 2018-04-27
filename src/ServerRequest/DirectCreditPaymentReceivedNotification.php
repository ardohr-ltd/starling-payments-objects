<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 * Notification that a direct credit has been received.
 */

use Consilience\Starling\Payments\AbstractServerRequest;

use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\BacsOriginator;
use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;

class DirectCreditPaymentReceivedNotification extends AbstractServerRequest
{
    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
    // phpcs:ignore
    protected $_webhookType = AbstractServerRequest::WEBHOOK_TYPE_MANDATE_DIRECT_CREDIT_RECEIVED;

    /**
     * @var string UUID
     * Unique identifier of the notification.
     */
    protected $notificationUid;

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
     * Unique identifier of the address the payment was sent from or received to.
     */
    protected $addressUid;

    /**
     * @var string UUID
     * Unique identifier of the direct credit payment.
     */
    protected $bacsPaymentUid;

    /**
     * @var string UUID
     * Unique identifier of the mandate under which it was intended that the payment was taken.
     */
    protected $mandateUid;

    /**
     * @var BacsOriginator
     */
    protected $bacsOriginator;

    /**
     * @var string
     * The originator defined reference for the mandate.
     */
    protected $reference;

    /**
     * @var CurrencyAndAmount
     */
    protected $amount;

    /**
     * @var string date-time e.g. 2017-06-05T11:47:58.801Z
     * Date and time that the payment was originally received.
     */
    protected $cancelledAt;

    /**
     * @return Carbon the cancelledAt as a Carbon object, with timezone preserved.
     */
    public function getCancelledAtCarbon()
    {
        return Carbon::parse($this->cancelledAt);
    }

    /**
     * CA party that is able to set up direct debit mandates
     * and send and receive payments via BACS.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setBacsOriginator(array $data)
    {
        $this->bacsOriginator = BacsOriginator::fromArray($data);
    }

    /**
     * @param array $data source data to hydrate the model
     */
    protected function setAmount(array $data)
    {
        $this->amount = CurrencyAndAmount::fromArray($data);
    }
}
