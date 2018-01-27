<?php

namespace Consilience\Starling\Payments;

/**
 *
 */

use Psr\Http\Message\ResponseInterface;

abstract class AbstractCollection implements
    \JsonSerializable,
    \Countable,
    \IteratorAggregate,
    \ArrayAccess
{
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

    /**
     * @return int
     */
    public function count()
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

    public function jsonSerialize()
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
    public function isEmpty()
    {
        return $this->count() == 0;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * @param mixed $item
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function assertStrictType($item)
    {
        if (! $this->hasExpectedStrictType($item)) {
            throw new \InvalidArgumentException('Item is not currect type or is empty.');
        }
    }

    public function first()
    {
        return reset($this->items);
    }

    //
    // ArrayAccess methods
    //

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    /**
     * Instantiate from a PSR-7 response.
     */
    public static function fromResponse(ResponseInterface $response)
    {
        // We can only deal with JSON response bodies.

        if ($response->getHeaderLine('Content-Type') === 'application/json') {
            $bodyData = json_decode((string)$response->getBody(), true);
            return new static($bodyData);
        }
    }
}
