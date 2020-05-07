<?php

namespace BMamba\Core;


use BMamba\Contracts\Core\Engine;

use BMamba\Traits\WithMagicFunction;
class ExecutionEngine implements Engine {
    use WithMagicFunction;

    protected $spider;

    public function handleDownloaderOutput($index, $response) {
        $this->scraper->enqueueScrape($response, $index, $this->spider);
    }

    public function openSpider($spider, $startRequest) {
        $this->spider = $spider;

        # 处理种子URL
        $this->schedule($startRequest);

    }

    public function schedule($urls) {
        $this->scheduler->enqueueRequest($urls);
    }


    public function download() {
        $this->downloader->download();
    }

    public function start() {
        # 开始下载
        $this->download();
    }

}