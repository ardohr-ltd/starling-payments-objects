<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 * Notification that a direct debit payment has been successfully made.
 */

use Consilience\Starling\Payments\AbstractServerRequest;

use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\BacsOriginator;
use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;

class DirectDebitPaymentPaidNotification extends DirectCreditPaymentReceivedNotification
{
    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
    // phpcs:ignore
    protected $_webhookType = AbstractServerRequest::WEBHOOK_TYPE_MANDATE_DIRECT_CREDIT_PAID;

    /**
     * @var string UUID
     * Unique identifier of the mandate under which the payment was taken.
     */
    protected $mandateUid;
}
