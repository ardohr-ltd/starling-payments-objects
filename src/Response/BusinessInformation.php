<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Retrieved payment business information.
 */

use Consilience\Starling\Payments\Response\Models\CurrencyAndAmount;
use Consilience\Starling\Payments\AbstractResponse;

class BusinessInformation extends AbstractResponse
{
    /**
     * @var string UUID
     * Unique identifier of the payment business.
     */
    protected $paymentBusinessUid;

    /**
     * @var string
     * Organisation name.
     */
    protected $name;

    /**
     * @var CurrencyAndAmount
     */
    protected $netSenderCap;

    /**
     * Create a model and set the property.
     *
     * @param array $data source data to hydrate the model
     */
    protected function setNetSenderCap(array $data)
    {
        $this->netSenderCap = CurrencyAndAmount::fromArray($data);
    }
}
