<?php

namespace Consilience\Starling\Payments;

/**
 *
 */

use Traversable;
use ArrayIterator;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Consilience\Starling\Payments\HasErrorsTrait;
use Prophecy\Doubler\ClassPatch\TraversablePatch;
use Consilience\Starling\Payments\HydratableTrait;

abstract class AbstractCollection implements
    \JsonSerializable,
    \Countable,
    \IteratorAggregate,
    \ArrayAccess
{
    use HydratableTrait;
    use HasErrorsTrait;

    protected $items = [];

    /**
     * @param mixed $item
     * @return bool
     */
    abstract protected function hasExpectedStrictType($item);

    /**
     * @param array $item
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $value) {
            $this->push($value);
        }
    }

    protected function setFromArray(array $items = [])
    {
        foreach ($items as $value) {
            $this->push($value);
        }
    }

    /**
     * @param array $item
     * @return self
     */
    public static function fromArray(array $items)
    {
        return new static($items);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param mixed $item
     * @return void
     */
    public function push($item)
    {
        // If we have an array, then we might want to
        // create an object of the appropriate type.

        if (is_array($item)) {
            $item = $this->createInstance($item);
        }

        $this->assertStrictType($item);

        $this->items[] = $item;
    }

    public function jsonSerialize(): mixed
    {
        $data = [];

        // Maybe filter for where hasAny() is true?
        foreach ($this as $item) {
            $data[] = $item;
        }

        return $data;
    }


    /**
     * @param array $data Data to instantiate an element in the collection.
     * @return object
     */
    abstract protected function createInstance(array $data);

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count() == 0;
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @param mixed $item
     * @throws InvalidArgumentException
     * @return void
     */
    protected function assertStrictType($item)
    {
        if (! $this->hasExpectedStrictType($item)) {
            throw new InvalidArgumentException('Item is not currect type or is empty.');
        }
    }

    public function first()
    {
        return reset($this->items);
    }

    //
    // ArrayAccess methods
    //

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    /**
     * Instantiate from a PSR-7 response.
     */
    public static function fromResponse(ResponseInterface $response)
    {
        // We can only deal with JSON response bodies.

        [$contentType] = explode(';', $response->getHeaderLine('Content-Type'));

        if (trim($contentType) === 'application/json') {
            $bodyData = json_decode((string)$response->getBody(), true);
            $collection = new static($bodyData);
        } else {
            $collection = new static();
        }

        // Move any HTTP errors into the errors stack and reset the success flag.

        $statusCode = $response->getStatusCode();
        $statusClass = (int) floor($statusCode / 100);
        $reasonPhrase = $response->getReasonPhrase();

        if ($statusClass !== 2) {
            $collection = $collection->withProperty('success', false);

            // Add an error message with the HTTP details.
            // Only do this if there are not already erros delivered from the remote host.

            if ($collection->getErrorCount() === 0) {
                $collection = $collection->withProperty(
                    'errors',
                    [
                        ['message' => sprintf('%d: %s', $statusCode, $reasonPhrase)],
                    ]
                );
            }
        }

        return $collection;
    }
}
