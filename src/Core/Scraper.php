<?php

namespace BMamba\Core;


use BMamba\Traits\WithMagicFunction;
use BMamba\Contracts\Core\Scraper as ScraperContract;

class Scraper implements ScraperContract
{
    use WithMagicFunction;

    public function callSpider($result, $index, $spider) {
        $callback  = $result->callback;;

        if(method_exists($spider, $callback)) {
            $returnResult = call_user_func([$spider, $callback], $result, $index);
            if($returnResult instanceof \Iterator) {
                $this->engine->schedule($returnResult);
            } else {
                $this->stats->scraper('item_scraped_count');
                $this->pipelines->processItem($returnResult);
            }
        }
    }

    public function enqueueScrape($response, $index, $spider) {
        $this->callSpider($response, $index, $spider);
    }

}