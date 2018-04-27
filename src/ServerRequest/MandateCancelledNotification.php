<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 * Webhook details of a direct debit mandate which has been received for an address.
 */

use Consilience\Starling\Payments\AbstractServerRequest;

use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\BacsOriginator;

class MandateCancelledNotification extends MandateCreatedNotification
{
    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
    // phpcs:ignore
    protected $_webhookType = AbstractServerRequest::WEBHOOK_TYPE_MANDATE_CANCELLED;

    /**
     * @var string date-time e.g. 2017-06-05T11:47:58.801Z
     * Time at which the mandate was cancelled.
     */
    protected $cancelledAt;

    /**
     * @return Carbon the receivedAt as a Carbon object, with timezone preserved.
     */
    public function getCancelledAtCarbon()
    {
        return Carbon::parse($this->cancelledAt);
    }
}
