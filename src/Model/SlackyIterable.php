<?php

namespace MatthijsThoolen\Slacky\Model;

use Iterator;
use function call_user_func;

class SlackyIterable implements Iterator
{
    /** @var array */
    private $data = [];

    /** @var int */
    private $index = 0;

    /** @var bool */
    private $hasMore = false;

    /** @var Callable */
    private $hasMoreCallback;

    public function __construct(
        array $data,
        bool $hasMore = false,
        Callable $hasMoreCallback = null
    )
    {
        $this->data            = $data;
        $this->hasMore         = $hasMore;
        $this->hasMoreCallback = $hasMoreCallback;
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->data[$this->index];
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->index++;

        if ($this->hasMore && !$this->valid()) {
            $response = call_user_func($this->hasMoreCallback);

            $this->hasMore = $response['hasMore'];

            array_push($this->data, ...$response['data']);
        }
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->data[$this->key()]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * Reverse the array
     */
    public function reverse()
    {
        $this->data = array_reverse($this->data);
        $this->rewind();
    }
}
