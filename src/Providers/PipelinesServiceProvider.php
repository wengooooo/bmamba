<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Providers;


use BMamba\Pipelines\ItemPipelineManager;
use BMamba\Contracts\Container\CrawlerContainer as Container;
use BMamba\Container\BMambaServiceProvider as ServiceProvider;


class PipelinesServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('pipelines', function (Container $app) {
            return $app->make(ItemPipelineManager::class);
        });
    }
}