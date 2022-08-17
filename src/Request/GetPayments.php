<?php

namespace Consilience\Starling\Payments\Request;

/**
 * Request to get a single payment account.
 */

use Consilience\Starling\Payments\Request\Models\Endpoint;
use Consilience\Starling\Payments\AbstractRequest;
use UnexpectedValueException;
use Carbon\Carbon;

class GetPayments extends AbstractRequest
{
    /**
     * @inherit
     */
    protected $pathTemplate = 'account/{accountUid}/address/{addressUid}/payment';

    protected $httpMethod = 'GET';

    protected $supportedQuery = ['direction', 'from', 'to', 'page'];

    protected $accountUid;
    protected $addressUid;

    protected $direction;
    protected $from;
    protected $to;
    protected $page;

    /**
     * @param string $paymentBusinessUid
     * @param string $accountUid the accound to retrieve
     */
    public function __construct(
        Endpoint $endpoint,
        $accountUid,
        $addressUid,
        $direction = null,
        $from = null,
        $to = null,
        $page = null
    ) {
        $this->setEndpoint($endpoint);
        $this->setAccountUid($accountUid);
        $this->setAddressUid($addressUid);

        $this->setDirection($direction);
        $this->setFrom($from);
        $this->setTo($to);
        $this->setPage($page);
    }

    /**
     * @param string UUID
     */
    protected function setAccountUid($value)
    {
        $this->assertUid($value);

        $this->accountUid = $value;
    }

    /**
     * @param string UUID
     */
    protected function setAddressUid($value)
    {
        $this->assertUid($value);

        $this->addressUid = $value;
    }

    /**
     * @param string
     */
    protected function setDirection($value)
    {
        // One of the valid address ststuses.
        if ($value !== null) {
            $this->assertInConstantList('DIRECTION_', $value);
        }

        $this->direction = $value;
    }

    /**
     * API accepted date format example: 2017-06-05T11:47:58.801Z
     *
     * @param Carbon|string
     */
    protected function setFrom($value)
    {
        if (is_string($value)) {
            $value = Carbon::parse($value, 'UTC');
        }

        if ($value instanceof Carbon) {
            $this->from = $value->tz('UTC')->format(static::ZULU_FORMAT);
        }
    }

    /**
     * @param Carbon|string
     */
    protected function setTo($value)
    {
        if (is_string($value)) {
            $value = Carbon::parse($value, 'UTC');
        }

        if ($value instanceof Carbon) {
            $this->to = $value->tz('UTC')->format(static::ZULU_FORMAT);
        }
    }

    /**
     * @param string UUID
     */
    protected function setPage($value)
    {
        // Must be a positive integer, 1 or higher, but is option (null allowed)
        if ($value !== null) {
            $this->assertPageNumber($value);
        }

        $this->page = $value;
    }

    /**
     * @return int the page number, defaulting to 1 if none were provided
     */
    public function getPageNumber()
    {
        return $this->getProperty('page') ?: 1;
    }

    /**
     * Increment the page number.
     *
     * @return self with the page number one higher
     */
    public function withNextPage()
    {
        $clone = clone $this;
        $clone->setProperty('page', $this->getPageNumber() + 1);
        return $clone;
    }
}
