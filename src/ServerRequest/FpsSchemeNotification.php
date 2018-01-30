<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 * Web hook payload for a notification received from the faster payment scheme.
 * Notification received from the faster payments scheme, typically this is a
 * change in the status of the payment such as an acknowledgement or rejection.
 */

use Consilience\Starling\Payments\AbstractServerRequest;

use Carbon\Carbon;

class FpsSchemeNotification extends AbstractServerRequest
{
    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
    // phpcs:ignore
    protected $_webhookType = AbstractServerRequest::WEBHOOK_TYPE_FPS_SCHEME;

    /**
     * @var string UUID
     * Unique identifier of the payment the notification relates to.
     */
    protected $paymentUid;

    /**
     * @var string once of static::PAYMENT_STATE_*
     * Current state of the payment in the FPS scheme.
     */
    protected $paymentState;

    /**
     * @var string length 0 to 8
     * FPS scheme reason code for the notification / state change.
     */
    protected $reasonCode;

    /**
     * @var string length 0 to 255
     * Human readable description of the reasonCode.
     */
    protected $reasonDescription;

    /**
     * @var string length 0 to 42 e.g. "YE78126Q54WK2J06M33020170720826608371     "
     * Unique identifier of the settlement cycle the payment has been assigned
     * to (where known).
     */
    protected $fpid;

    /**
     * @var string UUID
     * Unique identifier of the settlement cycle the payment has been assigned
     * to (where known).
     */
    protected $settlementCycleUid;

    /**
     * @var string one of static::FPS_CYCLE_*
     * Settlement cycle of the payment (where known).
     */
    protected $settlementCycle;

    /**
     * @var string date format YYYY-MM-DD
     * Settlement date of the payment (where known).
     */
    protected $settlementDate;

    /**
     * @var string date-time format 2017-06-05T11:47:58.801Z
     * Timestamp of the notification from the scheme.
     * This will generally be some seconds after the original SIP request.
     */
    protected $timestamp;

    /**
     * @return Carbon the fpsSettlementDate as a Carbon object, UTC with 00:00 time.
     */
    public function getSettlementDateCarbon()
    {
        // The ! prefix forces the time to zero.
        return Carbon::createFromFormat('!Y-m-d', $this->settlementDate, 'UTC');
    }

    /**
     * @return Carbon the timestamp as a Carbon object, with timezone preserved.
     * Timestamp of the notification from the scheme.
     */
    public function getTimestampCarbon()
    {
        return Carbon::parse($this->timestamp);
    }

    /**
     * Indicate whether this failed payment is retry-able.
     */
    public function isRetryable()
    {
        // Needs to have been rejected.

        if ($this->status !== static::PAYMENT_STATUS_REJECTED) {
            return false;
        }

        // Needs to be a retryable reason code.

        if (! in_array((int)$this->reasonCode, static::RETRYABLE_REASON_CODES, true)) {
            return false;
        }

        return true;
    }
}
