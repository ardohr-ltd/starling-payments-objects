<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 * Notification for the redirection of a faster payment due to a change
 * in the recipient account details.
 */

use Consilience\Starling\Payments\AbstractServerRequest;

use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\PaymentReturnDetails;
use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;
use Consilience\Starling\Payments\Response\Models\AccountNumberAndSortCode;
use Consilience\Starling\Payments\Response\Models\PaymentRejectionReason;

class FpsRedirectionNotification extends AbstractServerRequest
{
    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
    // phpcs:ignore
    protected $_endpoint = 'fps-redirection';

    /**
     * @var string UUID
     * Unique identifier of the notification.
     */
    protected $notificationUid;

    /**
     * @var string UUID
     * Unique identifier of the payment.
     */
    protected $paymentUid;

    /**
     * @var AccountNumberAndSortCode
     */
    protected $originalAccount;

    /**
     * @var AccountNumberAndSortCode
     */
    protected $redirectedAccount;

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setOriginalAccount(array $data)
    {
        $this->originalAccount = AccountNumberAndSortCode::fromArray($data);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setRedirectedAccount(array $data)
    {
        $this->redirectedAccount = AccountNumberAndSortCode::fromArray($data);
    }
}
