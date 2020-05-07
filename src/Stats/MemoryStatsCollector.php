<?php


namespace BMamba\Stats;


use GuzzleHttp\TransferStats;

class MemoryStatsCollector extends StatsCollector
{


    public function downloadExceptionLog($reason) {
        $this->container['stats']->incValue(sprintf('downloader/exception_count'));
        $this->container['stats']->incValue(sprintf('downloader/exception_count/%s', str_replace('\\', '.', get_class($reason))));
        $this->container['stats']->incValue(sprintf('downloader/exception_count/status/%s', $reason->getHandlerContext()['errno']));
    }

    public function retryLog() {

    }

}