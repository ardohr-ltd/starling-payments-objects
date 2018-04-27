<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 * Webhook details of a direct debit mandate which has been received for an address.
 */

use Consilience\Starling\Payments\AbstractServerRequest;

use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\BacsOriginator;

class MandateCreatedNotification extends AbstractServerRequest
{
    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
    // phpcs:ignore
    protected $_webhookType = AbstractServerRequest::WEBHOOK_TYPE_MANDATE_CREATED;

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
     * Unique identifier of the mandate that has been created.
     */
    protected $mandateUid;

    /**
     * @var string
     * The originator defined reference for the mandate.
     */
    protected $reference;

    /**
     * @var string date-time e.g. 2017-06-05T11:47:58.801Z
     * Date and time that the payment was originally received.
     */
    protected $receivedAt;

    /**
     * CHECKME: this name looks wrong, but is what is in the docs.
     * @var BacsOriginator
     */
    protected $originatorUid;

    /**
     * @return Carbon the receivedAt as a Carbon object, with timezone preserved.
     */
    public function getReceivedAtCarbon()
    {
        return Carbon::parse($this->receivedAt);
    }

    /**
     * CA party that is able to set up direct debit mandates
     * and send and receive payments via BACS.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setOriginatorUid(array $data)
    {
        $this->originatorUid = BacsOriginator::fromArray($data);
    }
}
