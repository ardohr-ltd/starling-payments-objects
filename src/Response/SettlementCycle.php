<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Settlement cycle over which payments made can be reconciled.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;
use Carbon\Carbon;

class SettlementCycle implements \JsonSerializable
{
    use HydratableTrait;

    /**
     * @var string
     */
    const DIRECTION_INBOUND     = 'INBOUND';
    const DIRECTION_OUTBOUND    = 'OUTBOUND';

    /**
     * @var string UUID
     * Unique identifier of the settlement cycle.
     */
    protected $settlementCycleUid;

    /**
     * @var string date-time e.g. 2017-06-10T07:00:00.000Z
     * Start date and time of the cycle.
     */
    protected $startTime;

    /**
     * @var string date-time e.g. 2017-06-10T07:00:00.000Z
     * End date and time of the cycle.
     */
    protected $endTime;

    /**
     * @var CurrencyAndAmount
     */
    protected $netPayment;

    /**
     * @var string One of static::DIRECTION_*
     * Net direction of movements during this period.
     */
    protected $netDirection;

    /**
     * @var integer
     * Number of inbound payments received during the cycle.
     */
    protected $inboundCount;

    /**
     * @var integer
     * Number of outbound payments received during the cycle.
     */
    protected $outboundCount;

    /**
     * @return Carbon the startTime as a Carbon object, with timezone preserved.
     */
    public function getStartTimeCarbon()
    {
        return Carbon::parse($this->startTime);
    }

    /**
     * @return Carbon the endTime as a Carbon object, with timezone preserved.
     */
    public function getEndTimeCarbon()
    {
        return Carbon::parse($this->endTime);
    }

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setNetPayment(array $data)
    {
        $this->netPayment = CurrencyAndAmount::fromArray($data);
    }
}
