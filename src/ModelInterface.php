<?php

namespace Consilience\Starling\Payments;

/**
 *
 */

interface ModelInterface extends \JsonSerializable
{
    /**
     * @var string
     */
    const FPS_CYCLE_001     = 'CYCLE_001';
    const FPS_CYCLE_002     = 'CYCLE_002';
    const FPS_CYCLE_003     = 'CYCLE_003';
    const FPS_CYCLE_UNKNOWN = 'CYCLE_UNKNOWN';

    /**
     * @var string
     */
    const PAYMENT_STATE_ACCEPTED = 'ACCEPTED';
    const PAYMENT_STATE_REJECTED = 'REJECTED';

    /**
     * @var string
     */
    const ACCOUNT_HOLDER_PAYMENT_BUSINESS   = 'PAYMENT_BUSINESS';
    const ACCOUNT_HOLDER_AGENCY             = 'AGENCY';

    /**
     * @var string account address status
     */
    const ADDRESS_STATUS_ACTIVE         = 'ACTIVE';
    const ADDRESS_STATUS_INSTRUCT_ONLY  = 'INSTRUCT_ONLY';
    const ADDRESS_STATUS_CLOSED         = 'CLOSED';
    const ADDRESS_STATUS_DECEASED       = 'DECEASED';

    /**
     * @var string
     */
    const DIRECTION_INBOUND     = 'INBOUND';
    const DIRECTION_OUTBOUND    = 'OUTBOUND';

    /**
     * @var string payment status
     */
    const PAYMENT_STATUS_PENDING    = 'PENDING';
    const PAYMENT_STATUS_ACCEPTED   = 'ACCEPTED';
    const PAYMENT_STATUS_REJECTED   = 'REJECTED';
    const PAYMENT_STATUS_REVERSED   = 'REVERSED';
    const PAYMENT_STATUS_REJECTED_PENDING_RETRY   = 'REJECTED_PENDING_RETRY';

    /**
     * @var string
     */
    const TYPE_SIP = 'SIP';
    const TYPE_SOP = 'SOP';
    const TYPE_FDP = 'FDP';
    const TYPE_SRN = 'SRN';
    const TYPE_RTN = 'RTN';
    const TYPE_DCA = 'DCA';

    /**
     * @var string
     */
    const TYPE_DOMESTIC_SIP = 'SIP';
    const TYPE_DOMESTIC_SOP = 'SOP';
    const TYPE_DOMESTIC_FDP = 'FDP';

    /**
     * @var string
     */
    const BALANCE_STATE_IN_CREDIT = 'IN_CREDIT';
    const BALANCE_STATE_OVERDRAWN = 'OVERDRAWN';

    /**
     * @var string
     */
    const SOURCE_BACS   = 'BACS';
    const SOURCE_CHAPS  = 'CHAPS';

    /**
     * @var string Used to set a reason when returning a payment.
     */
    const PAYMENT_RETURN_REASON_ACCOUNT_UNKNOWN = 'ACCOUNT_UNKNOWN';
    const PAYMENT_RETURN_REASON_ACCOUNT_CLOSED = 'ACCOUNT_CLOSED';
    const PAYMENT_RETURN_REASON_ACCOUNT_STOPPED = 'ACCOUNT_STOPPED';
    const PAYMENT_RETURN_REASON_ACCOUNT_HOLDER_DECEASED = 'ACCOUNT_HOLDER_DECEASED';
    const PAYMENT_RETURN_REASON_REFERENCE_REQUIRED_NOT_SUPPLIED = 'REFERENCE_REQUIRED_NOT_SUPPLIED';
    const PAYMENT_RETURN_REASON_ACCOUNT_NAME_MISSMATCH = 'ACCOUNT_NAME_MISSMATCH';
    const PAYMENT_RETURN_REASON_RETURN_REQUESTED_BY_SENDER = 'RETURN_REQUESTED_BY_SENDER';
    const PAYMENT_RETURN_REASON_RETURN_REQUESTED_BY_BENEFICIARY = 'RETURN_REQUESTED_BY_BENEFICIARY';
    const PAYMENT_RETURN_REASON_TERMS_AND_CONDITIONS_OF_ACCOUNT_DO_NOT_PERMIT_CREDITING_OF_THESE_FUNDS =
        'TERMS_AND_CONDITIONS_OF_ACCOUNT_DO_NOT_PERMIT_CREDITING_OF_THESE_FUNDS';
    const PAYMENT_RETURN_REASON_SENDING_INSTITUTION_ACTION_REQUIRED = 'SENDING_INSTITUTION_ACTION_REQUIRED';
    const PAYMENT_RETURN_REASON_ACCOUNT_TRANSFERRED = 'ACCOUNT_TRANSFERRED';
    const PAYMENT_RETURN_REASON_REASON_NOT_SPECIFIED = 'REASON_NOT_SPECIFIED';
    const PAYMENT_RETURN_REASON_OTHER = 'OTHER';

    /**
     * API accepted date format example: 2017-06-05T11:47:58.801Z
     * ISO 8601 or "Zulu time" when expressing UTC "yyyy-MM-dd'T'HH:mm:ss.SSS'Z'"
     * It is possible the API accepts all ISO 8601 formats, including with time
     * offsets, but that is not documented and has not been tested.
     * Make sure the time has been converted to UTC before using this format, for
     * correct interpretation.
     *
     * @var string The "Zulu" datetime format used, with microseconds.
     */
    const ZULU_FORMAT = 'Y-m-d\TH:i:s.u\Z';

    /**
     * @var integer the size of a page when fetching payments
     */
    const PAGE_SIZE = 100;

    /**
     * @var int List of response failure reason codes that are retryable.
     */
    const RETRYABLE_REASON_CODES = [9909, 9910, 9911, 9912, 9913];
}
