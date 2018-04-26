<?php

namespace Consilience\Starling\Payments\Response;

/**
 * Response to the request to activate a mandate.
 */

use Consilience\Starling\Payments\AbstractResponse;

class ActivateMandateResponse extends AbstractResponse
{
    /**
     * @var string UUID
     * Unique identifier of the mandate.
     */
    protected $mandateUid;

    /**
     * The mandate that was requested for activation.
     */
    public function getMandateUid()
    {
        return $this->getProperty('mandateUid');
    }
}
