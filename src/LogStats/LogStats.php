<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\LogStats;


use BMamba\Contracts\Container\CrawlerContainer;
use BMamba\Traits\WithMagicFunction;

class LogStats
{
    use WithMagicFunction;
    
    protected $container;
    protected $interval;
    protected $multiplier;
    protected $pagesprev;
    protected $itemsprev;
    protected $nextruntime;

    public function __construct(CrawlerContainer $container) {
        $this->container = $container;
        $this->interval = $this->config->get('settings.LOGSTATS_INTERVAL');
        $this->multiplier = 60 / $this->interval;
        $this->pagesprev = 0;
        $this->itemsprev = 0;

        $this->nextruntime = $this->getNextRunTime();
    }

    public function spiderLog() {
        $this->log->info(['component' => get_class($this), 'message' => sprintf('Black Mamba %s Started', 1.0)]);
        $this->log->info(['component' => get_class($this), 'message' => sprintf('Load providers : %s', $this->log->formatArray($this->container->getServiceProviders()))]);
        $this->log->info(['component' => get_class($this), 'message' => sprintf('Enabled downloader middlewares : %s', $this->log->formatArray(
            array_merge(array_keys($this->config->get("settings.DOWNLOADER_MIDDLEWARES")), array_keys($this->config->get("settings.DOWNLOADER_MIDDLEWARES_BASE")))
        ))]);
        $this->log->info(['component' => get_class($this), 'message' => sprintf('Enabled spider middlewares: : %s', $this->log->formatArray(array_keys($this->config->get("settings.SPIDER_MIDDLEWARES"))))]);
        $this->log->info(['component' => get_class($this), 'message' => 'Spider opened']);

    }

    public function log() {
        if(strtotime(date("Y-m-d H:i:s")) > strtotime($this->nextruntime)) {
            $items = $this->stats->getValue('item_scraped_count', 0);
            $pages = $this->stats->getValue('response_received_count', 0);
            $irate = ($items - $this->itemsprev) * $this->multiplier;
            $prate = ($pages - $this->pagesprev) * $this->multiplier;

            $this->pagesprev = $pages;
            $this->itemsprev = $items;

            $msg = sprintf("Crawled %d pages (at %d pages/min), scraped %d items (at %d items/min)", $pages, $prate, $items, $irate);

            $this->log->info(['component' => get_class($this), 'message' => $msg]);
            $this->nextruntime = $this->getNextRunTime();
        }
    }

    public function getNextRunTime() {
        return date("Y-m-d H:i:s", strtotime(sprintf("+%d sec", $this->interval)));
    }
}