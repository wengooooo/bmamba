<?php

namespace BMamba\Queue;

use SplDoublyLinkedList;
use SplQueue;

class FIFOQueue extends SplQueue
{
    public function __construct()
    {
        $this->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_DELETE);
    }
}