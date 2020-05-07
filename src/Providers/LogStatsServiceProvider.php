<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Providers;


use BMamba\Contracts\Downloader\IDownloader;
use BMamba\Contracts\Engine\IEngine;
use BMamba\Contracts\Scheduler\IScheduler;
use BMamba\LogStats\LogStats;
use BMamba\Scraper\Scraper;
use BMamba\Contracts\Container\CrawlerContainer as Container;
use BMamba\Container\BMambaServiceProvider as ServiceProvider;


class LogStatsServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('log.stats', function (Container $container) {
            return $container->make(LogStats::class);
        });
    }
}