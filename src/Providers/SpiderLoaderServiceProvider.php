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

class SpiderLoaderServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('spider.loader', function (Container $container) {
            return $container->make($container->config->get('settings.SPIDER_LOADER_CLASS'));
        });
    }
}