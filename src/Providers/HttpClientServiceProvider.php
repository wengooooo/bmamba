<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Providers;


use BMamba\HttpClient\HttpClient;
use BMamba\HttpClient\HttpHandler;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use BMamba\Contracts\Container\CrawlerContainer as Container;
use BMamba\Container\BMambaServiceProvider as ServiceProvider;

class HttpClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('http.client', function (Container $app) {
//            return new Client();
//            return $app->make(new Client());
            return $app->make(HttpClient::class);
        });

        $this->app->singleton('http.handler', function (Container $app) {
            return $app->make(HttpHandler::class);
//            return $app->make(HttpClient::class);
        });
    }
}