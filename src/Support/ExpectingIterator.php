<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Support;


class ExpectingIterator implements \Iterator
{
    /**
     * @var \Iterator
     */
    private $inner;
    private $wasValid;

    public function __construct(\Iterator $inner)
    {
        $this->inner = $inner;
    }

    public function next()
    {
        if (!$this->wasValid && $this->valid()) {
            // Just do nothing, because the inner iterator has became valid
        } else {
            $this->inner->next();
        }

        $this->wasValid = $this->valid();
    }

    public function current()
    {
        return $this->inner->current();
    }

    public function rewind()
    {
        $this->inner->rewind();

        $this->wasValid = $this->valid();
    }

    public function key()
    {
        return $this->inner->key();
    }

    public function valid()
    {
        return $this->inner->valid();
    }
}