<?php

namespace BMamba\Spiders;

use BMamba\Http\Request;
use BMamba\Contracts\Spiders\Spider as SpiderContract;

class Spider implements SpiderContract
{
    public $startUrls;

    public function startRequests()
    {
        foreach($this->startUrls as $url) {
            yield new Request('GET', $url, 'parse', ['testmeta' => 'meta']);
        }
    }

    public function makeRequestsFromUrl($url) {
        return new Request("GET", $url);
    }

}