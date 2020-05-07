<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\HttpClient;


use BMamba\Contracts\Container\CrawlerContainer;
use GuzzleHttp\HandlerStack;

class HttpHandler
{
    /* @var \GuzzleHttp\HandlerStack*/
    private $stack;
    protected $container;
    public function __construct(CrawlerContainer $container)
    {
        $this->container = $container;
        $this->createHandlerStack();
        $this->addMiddlewares();
    }

    private function createHandlerStack() {
        $this->stack = HandlerStack::create();
    }

    public function addMiddlewares() {
        foreach(array_keys($this->container['config']->get('settings.DOWNLOADER_MIDDLEWARES_BASE')) as $middleware) {
            $this->addMiddleware($middleware);
        }
    }

    public function addMiddleware($middleware) {
        $middlewareCls = $this->container->make($middleware);
        if(method_exists($middlewareCls, 'processResponse')) {
            $this->stack->push(call_user_func([$middlewareCls, 'processResponse']));
        }

        if(method_exists($middlewareCls, 'processRequest')) {
            $this->stack->push(call_user_func([$middlewareCls, 'processRequest']));
        }

        if(!method_exists($middlewareCls,'processRequest') && !method_exists($middlewareCls,'processResponse')) {
            $this->stack->push(function (callable $handler) use($middlewareCls) {
                return $middlewareCls($handler);
            });
        }
    }

    public function getHandler() {
        return $this->stack;
    }
}