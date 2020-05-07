<?php

namespace BMamba\Middlewares;

use BMamba\Contracts\Container\CrawlerContainer;
use GuzzleHttp\HandlerStack;

class MiddlewareManager
{
   protected $container;
   public function __construct(CrawlerContainer $container)
   {
        $this->container = $container;
   }

}