<?php

namespace Consilience\Starling\Payments\Request\Models;

/**
 * Defines the endpoint for the gateway.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Uri;

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
        $this->assertUid($value);

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

    /**
     * Return the sandbox or production hostname, depending on what instance
     * has been selected for this object.
     *
     * @return string the hostname
     */
    public function getHost()
    {
        $instanceName = 'host' . ucfirst($this->getProperty('instance'));

        return $this->$instanceName;
    }
    /**
     * Piece the parts of the URL template together and replace the
     * placeholder fields with values from the matching getters.
     *
     * @return Uri PSR-7 Uri object
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

        foreach ($fieldNames as $fieldName) {
            $replacements['{' . $fieldName . '}'] = $this->getProperty($fieldName);
        }

        // A URL with an authority must start with a slash.

        $path = '/' . ltrim(
            str_replace(
                array_keys($replacements),
                array_values($replacements),
                $template
            ),
        '/');

        $uri = new Uri();

        $uri = $uri
            ->withScheme($this->scheme)
            ->withPath($path)
            ->withHost($this->host);

        if (! empty($query)) {
            $uri = $uri->withQuery(Query::build($query));
        }

        return $uri;
    }
}
