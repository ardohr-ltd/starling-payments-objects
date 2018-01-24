<?php

namespace Consilience\Starling\Payments;

/**
 * Support for generating a PSR-7 request message.
 */

use Consilience\Starling\Payments\HydratableTrait;
use Consilience\Starling\Payments\ValidationTrait;
use Consilience\Starling\Payments\ModelInterface;

use Consilience\Starling\Payments\Request\Model\Endpoint;

abstract class AbstractRequest implements ModelInterface
{
    use HydratableTrait;
    use ValidationTrait;

    /**
     * The template for the path to the service, from the root path.
     * Substitution variables use the {curlyBrackets} notation.
     *
     * @var string
     */
    protected $pathTemplate = '';

    /**
     * The service HTTP method.
     *
     * @var string
     */
    protected $httpMethod = 'GET';

    /**
     * @var Endpoint
     */
    protected $endpoint;

    /**
     * @var array default headers that are added to the message
     */
    protected $httpHeaders = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];

    /**
     * @var array a list of supported query parameters
     */
    protected $supportedQuery = [];

    /**
     * Get the path to the service, to be appended to the root path.
     * Variable placeholders are substituted.
     *
     * @return string
     */
    public function getServicePath()
    {
        $template = trim($this->pathTemplate, '/');

        // Extract the template field names, "{fooBar}" as "fooBar".
        preg_match_all('/(?<={)[a-zA-Z0-9]+(?=})/', $template, $matches);
        $fieldNames = $matches[0];

        $replacements = [];

        foreach($fieldNames as $fieldName) {
            $replacements['{' . $fieldName . '}'] = $this->getProperty($fieldName);
        }

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $template
        );
    }

    /**
     * Get the PSR-7 request message.
     * We are using the Guzzle PSR-7 implementation to do this, and you can
     * still use any HTTP client you like with the result.
     *
     * @return Psr\Http\Message\RequestInterface
     */
    public function getRequestMessage()
    {
        // Set the default headers.
        // The signing middleware will add more headers.
        $headers = $this->getProperty('httpHeaders');

        // Some messages do not have bodies.
        $body = $this->jsonSerialize() !== null ? json_encode($this) : null;
dump($body);
        return new \GuzzleHttp\Psr7\Request(
            $this->getProperty('httpMethod'),
            $this->getUri(),
            $headers,
            $body
        );
    }

    public function getUri()
    {
        // Check for any query parameters that may be supported,
        // and collect any together that are not set.

        $query = [];
        foreach ($this->supportedQuery as $queryName) {
            $queryValue = $this->getProperty($queryName);

            if ($queryValue !== null) {
                $query[$queryName] = (string)$queryValue;
            }
        }

        return $this->getProperty('endpoint')->getUrl($this->getServicePath(), $query);
    }

    /**
     * @param Endpoint
     */
    protected function setEndpoint(Endpoint $value)
    {
        $this->endpoint = $value;
    }

    /**
     * @param array
     */
    protected function setHttpHeaders(array $value)
    {
        $this->httpHeaders = $value;
    }

    /**
     * @return null an empty body by default
     */
    public function jsonSerialize()
    {
        return;
    }
}
