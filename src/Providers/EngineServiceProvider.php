<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Providers;


use BMamba\Contracts\Container\CrawlerContainer as Container;
use BMamba\Container\BMambaServiceProvider as ServiceProvider;


class EngineServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('engine', function (Container $container) {
            return $container->make($container->config->get('settings.ENGINE'));
        });
    }
}