<?php

namespace BMamba\Core;


use BMamba\Contracts\Container\CrawlerContainer;
use BMamba\Traits\WithMagicFunction;
use BMamba\Contracts\Core\Crawler as CrawlerContracts;

class Crawler implements CrawlerContracts
{
    use WithMagicFunction;

    /**
    * @var \BMamba\Contracts\Container\CrawlerContainer
     */
    protected $container;

    protected $spider;

    public function __construct(CrawlerContainer $container) {
        $this->container = $container;

        $this->container['log.stats']->spiderLog();

        # 注册采集完毕
        register_shutdown_function($this->closeSpider());

        if(function_exists('sapi_windows_set_ctrl_handler')) {
            sapi_windows_set_ctrl_handler([$this, 'closeSpider']);
        }
    }

    public function crawl($spiderName) {
        # 建立爬虫
        $spider = $this->createSpider($spiderName);

        # 获取种子URL
        $startRequests = $spider->startRequests();

        # 引擎打开爬虫
        $this->openSpider($spider, $startRequests);

        # 启动引擎
        $this->start();
    }

    private function createSpider($spiderName) {
        return $this->container['spider.loader']->load($spiderName);
    }

    private function openSpider($spider, $startRequest) {
        $this->engine->openSpider($spider, $startRequest);
    }

    private function start() {
        $this->engine->start();
    }

    public function closeSpider() {
        return function() {
            $err = error_get_last();
            if (!$err || ($err['type'] ^ E_ERROR)) {
                $this->stats->dumps();
            }
        };
    }

}