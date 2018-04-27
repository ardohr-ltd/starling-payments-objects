<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 * Notification that the originator associated with a direct debit mandate has
 * changed - this results in the replacing of the associated mandate with another
 * one with the same reference.
 */

use Consilience\Starling\Payments\AbstractServerRequest;

use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\BacsOriginator;

class MandateOriginatorChangedNotification extends AbstractServerRequest
{
    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
    // phpcs:ignore
    protected $_webhookType = AbstractServerRequest::WEBHOOK_TYPE_MANDATE_ORIGINATOR_CHANGED;

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
     * Unique identifier of the mandate for the old originator.
     */
    protected $oldMandateUid;

    /**
     * @var string UUID
     * Unique identifier of the mandate for the new originator.
     */
    protected $newMandateUid;

    /**
     * @var BacsOriginator
     */
    protected $oldOriginator;

    /**
     * @var BacsOriginator
     */
    protected $newOriginator;

    /**
     * @var string date-time e.g. 2017-06-05T11:47:58.801Z
     * Time at which the originator was changed.
     */
    protected $changedAt;

    /**
     * @var string
     * The originator defined reference for the mandate.
     */
    protected $reference;

    /**
     * @return Carbon the receivedAt as a Carbon object, with timezone preserved.
     */
    public function getChangedAtCarbon()
    {
        return Carbon::parse($this->receivedAt);
    }

    /**
     * CA party that is able to set up direct debit mandates
     * and send and receive payments via BACS.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setOldOriginator(array $data)
    {
        $this->oldOriginatorUid = BacsOriginator::fromArray($data);
    }

    /**
     * CA party that is able to set up direct debit mandates
     * and send and receive payments via BACS.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setNewOriginator(array $data)
    {
        $this->newOriginatorUid = BacsOriginator::fromArray($data);
    }
}
