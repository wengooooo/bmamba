<?php

namespace BMamba\Providers;


use BMamba\Contracts\Container\CrawlerContainer as Container;
use BMamba\Container\BMambaServiceProvider as ServiceProvider;


class DownloaderServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('downloader', function (Container $container) {
            return $container->make($container['config']->get('settings.DOWNLOADER'));
        });
    }
}