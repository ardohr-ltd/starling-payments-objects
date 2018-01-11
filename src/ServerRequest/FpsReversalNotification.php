<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 * Notification of a reversal by the scheme of a previously received inbound payment.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;

use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\PaymentReturnDetails;
use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;
use Consilience\Starling\Payments\Response\Models\PaymentDetailsAccount;
use Consilience\Starling\Payments\Response\Models\PaymentRejectionReason;

class FpsReversalNotification implements ModelInterface
{
    use HydratableTrait;

    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
    protected $_endpoint = 'fps-inbound';

    /**
     * @var string UUID
     * Unique identifier of the notification.
     */
    protected $notificationUid;

    // Note the following are in reverse order compared to most other messages.

    /**
     * @var string UUID
     * Unique identifier of the payment.
     */
    protected $paymentUid;

    /**
     * @var string UUID
     * Unique identifier of the address the payment was sent from or received to.
     */
    protected $addressUid;

    /**
     * @var string UUID
     * Unique identifier of the account containing the funds sent or received.
     */
    protected $paymentAccountUid;

    /**
     * @var CurrencyAndAmount
     */
    protected $reversalAmount;

    /**
     * @var string length 0 to 8 e.g. 9912
     * FPS scheme reason code for the payment reversal.
     */
    protected $reasonCode;

    /**
     * @var string length 0 to 255
     * Human readable description of the reasonCode.
     */
    protected $reasonDescription;

    /**
     * @var string date-time e.g. 2017-06-05T11:47:58.801Z
     * Timestamp of the notification from the scheme.
     */
    protected $timestamp;

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setReversalAmount(array $data)
    {
        $this->reversalAmount = CurrencyAndAmount::fromArray($data);
    }

    /**
     * @return Carbon the timestamp as a Carbon object, with timezone preserved.
     */
    public function getTimestampAtCarbon()
    {
        return Carbon::parse($this->receivedAt);
    }
}
