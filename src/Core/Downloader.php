<?php

namespace BMamba\Core;


use BMamba\Traits\WithMagicFunction;
use BMamba\Http\Response;
use \BMamba\Contracts\Core\Downloader as DownloaderContract;

class Downloader implements DownloaderContract
{
    use WithMagicFunction;

    /* @var \BMamba\Contracts\Crawler\ICrawlerContainer */

    public function download() {
        while($this->scheduler->getSize() > 0) {
            $pool = new \GuzzleHttp\Pool($this->container['http.client']->getClient(), $this->scheduler->nextRequest(), [
                'concurrency' => $this->config->get("settings.CONCURRENT_REQUESTS"),
                'fulfilled' => function ($response, $index) {
                    $response = new Response($response);
                    $this->engine->handleDownloaderOutput($index, $response);
                },
                'rejected' => function ($reason, $index) {
                    $this->stats->downloader($reason);
//                $this->container['engine']->handleDownloaderError($index, $reason);
                }
            ]);

            $pool->promise()->wait();
        }


    }

}