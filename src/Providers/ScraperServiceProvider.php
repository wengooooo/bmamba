<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Providers;


use BMamba\Core\Scraper;
use BMamba\Contracts\Container\CrawlerContainer as Container;
use BMamba\Container\BMambaServiceProvider as ServiceProvider;


class ScraperServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('scraper', function (Container $container) {
            return $container->make(Scraper::class);
        });
    }
}