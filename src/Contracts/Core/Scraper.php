<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Contracts\Core;


interface Scraper
{
    public function callSpider($result, $index, $spider);
    public function enqueueScrape($response, $index, $spider);
}