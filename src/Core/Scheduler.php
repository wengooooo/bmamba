<?php

namespace BMamba\Core;

use BMamba\Queue\FIFOQueue;
use BMamba\Traits\WithMagicFunction;
use GuzzleHttp\Psr7\Request;
use BMamba\Support;
use BMamba\Contracts\Container\CrawlerContainer;
class Scheduler
{
    use WithMagicFunction;
    protected $queue;
    protected $container;

    public function __construct(CrawlerContainer $container)
    {
        $this->queue = new FIFOQueue();
        $this->container = $container;
    }

    public function enqueueRequest($requests) {
        foreach($requests as $request) {
            $this->stats->schedule('scheduler/enqueued');
            $this->queue->enqueue($request);
        }
    }

    public function nextRequest() {
        foreach($this->queue as $request) {
            $this->stats->schedule('scheduler/dequeued');
            yield $request;
        }
    }

    public function getSize() {
        return $this->queue->count();
    }

}