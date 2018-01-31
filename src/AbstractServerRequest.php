<?php

namespace Consilience\Starling\Payments;

/**
 * Support for generating a PSR-7 request message.
 */

use InvalidArgumentException;
use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ModelInterface;
use Consilience\Starling\Payments\Request\Models\Endpoint;

abstract class AbstractServerRequest implements ModelInterface
{
    use HydratableTrait;

    /**
     * @var string List of expected services (path extending the webhook base URL).
     */

    // Notification received from the faster payments scheme, typically this is a change
    // in the status of the payment such as an acknowledgement or rejection.
    const WEBHOOK_TYPE_FPS_SCHEME            = 'fps-scheme';

    // Notification of a new inbound payment received to an address for an account managed
    // by the payment business.
    const WEBHOOK_TYPE_FPS_INBOUND           = 'fps-inbound';

    // Notification of a reversal by the scheme of a previously received inbound payment.
    const WEBHOOK_SERVICE_FPS_REVERSAL          = 'fps-reversal';

    // Notification of the redirection of an outbound payment instruction.
    const WEBHOOK_TYPE_FPS_REDIRECTION       = 'fps-redirection';

    // Notification for a credit or deduction transaction applied directly to
    // an account, rather than through an address on a payment scheme.
    const WEBHOOK_TYPE_ACCOUNT_TRANSACTION   = 'account-transaction';

    /**
     * @var string the endpoint path the webhook will be delivered on.
     */
    // phpcs:ignore
    protected $_webhookType = '';

    /**
     * @var string UUID
     * Unique identifier of the notification.
     */
    protected $notificationUid;

    /**
     * @var array webhook type to classname mapping
     */
    protected static $webhookTypeClasses = [
        self::WEBHOOK_TYPE_FPS_SCHEME => 'FpsSchemeNotification',
        self::WEBHOOK_TYPE_FPS_INBOUND => 'FpsInboundNotification',
        self::WEBHOOK_SERVICE_FPS_REVERSAL => 'FpsReversalNotification',
        self::WEBHOOK_TYPE_FPS_REDIRECTION => 'FpsRedirectionNotification',
        self::WEBHOOK_TYPE_ACCOUNT_TRANSACTION => 'AccountTransactionNotification',
    ];

    /**
     * Instantiate a webhook object.
     *
     * @param string $webhookType one of static::WEBHOOK_TYPE_*
     * @param array $data the received webhook body data
     * @return AbstractServerRequest the appropriate class instantiated
     * @throws ??? if the webhookType is not valid
     */
    public static function fromData($webhookType, array $data)
    {
        if (! array_key_exists($webhookType, static::$webhookTypeClasses)) {
            // We may want to return a default "generic" class just to record the
            // webhook and not to be forced to abort.
            throw new InvalidArgumentException(sprintf(
                'Invalid webhook type "%s"; expecting one of: %s',
                $webhookType,
                implode(', ', array_values(static::$webhookTypeClasses))
            ));
        }

        $classFullName = '\Consilience\Starling\Payments\ServerRequest\\'
            . static::$webhookTypeClasses[$webhookType];

        $object = new $classFullName($data);

        return $object;
    }

    public function getWebhookType()
    {
        return $this->_webhookType;
    }
}