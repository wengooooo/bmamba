<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Traits;


use BMamba\Contracts\Container\CrawlerContainer;

trait WithMagicFunction
{
    /* @var \BMamba\Contracts\Container\CrawlerContainer */
    protected $container;

    public function __construct(CrawlerContainer $container) {
        $this->container = $container;
    }

    public function __get($name) {
        return $this->container[$name];
    }
}