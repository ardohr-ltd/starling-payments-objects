<?php

namespace Consilience\Starling\Payments\ServerRequest;

/**
 * Notification for the redirection of a faster payment due to a change
 * in the recipient account details.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;

use Carbon\Carbon;
use Consilience\Starling\Payments\Response\Models\PaymentReturnDetails;
use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;
use Consilience\Starling\Payments\Response\Models\PaymentDetailsAccount;
use Consilience\Starling\Payments\Response\Models\PaymentRejectionReason;

class FpsRedirectionNotification implements ModelInterface
{
    use HydratableTrait;

    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
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
     * @var PaymentDetailsAccount
     */
    protected $originalAccount;

    /**
     * @var PaymentDetailsAccount
     */
    protected $redirectedAccount;

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setOriginalAccount(array $data)
    {
        $this->originalAccount = PaymentDetailsAccount::fromArray($data);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setRedirectedAccount(array $data)
    {
        $this->redirectedAccount = PaymentDetailsAccount::fromArray($data);
    }
}
