<?php

namespace Consilience\Starling\Payments\Request\Model;

/**
 * Defines the endpoint for the gateway.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;
use UnexpectedValueException;

use GuzzleHttp\Psr7\build_query;

// TODO: implements a request interface of some sort.
// TODO: supports delivering of a PSR-7 request.
// TODO: paymentBusinessUid
// TODO: build the path (auto-substritution would be nice).
// TODO: handling additional GET parameters, maybe filtering and validating those that are supported
// TODO: define method
// TODO: how does using a PSR-7 message interact with the authorisation signing? Hopefully it doesn't.

class Endpoint implements ModelInterface
{
    use HydratableTrait;
    use ValidationTrait;

    const INSTANCE_SANDBOX      = 'sandbox';
    const INSTANCE_PRODUCTION   = 'production';

    protected $paymentBusinessUid;
    protected $instance;

    protected $scheme = 'https';

    protected $hostSandbox = 'payment-api-sandbox.starlingbank.com';
    protected $hostProduction = 'payment-api.starlingbank.com';

    protected $basePathTemplate = 'api/v1/{paymentBusinessUid}';

    /**
     * @param string $paymentBusinessUid
     * @param string $instance one of static::INSTANCE_*
     */
    public function __construct($paymentBusinessUid, $instance = self::INSTANCE_SANDBOX)
    {
        $this->setPaymentBusinessUid($paymentBusinessUid);
        $this->setInstance($instance);
    }

    /**
     * @param string UUID
     */
    protected function setPaymentBusinessUid($value)
    {
        //$this->assertUid($value);

        $this->paymentBusinessUid = $value;
    }

    /**
     * @param string string
     */
    protected function setInstance($value)
    {
        $this->assertInConstantList('INSTANCE_', $value);

        $this->instance = $value;
    }

    public function getHost()
    {
        $instanceName = 'host' . ucfirst($this->getProperty('instance'));

        return $this->$instanceName;
    }
    /**
     * Piece the parts of the URL template together and replace the
     * placeholder fields with values from the matching getters.
     *
     * TOOD: return a PSR-8 URI object, built from the parts.
     *
     * @return string the full URL
     */
    public function getUrl($servicePath = '', $query = [])
    {
        // Join the parts to make the full template.
        $template = implode('/', [
            $this->basePathTemplate,
            $servicePath,
        ]);

        // Extract the template field names, "{fooBar}" as "fooBar".
        preg_match_all('/(?<={)[a-zA-Z0-9]+(?=})/', $template, $matches);
        $fieldNames = $matches[0];

        $replacements = [];

        foreach($fieldNames as $fieldName) {
            $replacements['{' . $fieldName . '}'] = $this->getProperty($fieldName);
        }

        $path = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $template
        );

        $uri = new \GuzzleHttp\Psr7\Uri();

        $uri = $uri
            ->withScheme('https')
            ->withPath($path)
            ->withHost($this->host);

        if (! empty($query)) {
            $uri = $uri->withQuery(\GuzzleHttp\Psr7\build_query($query));
        }

        return $uri;
    }
}
