<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Contracts\Core;


interface Crawler
{
    public function crawl($spiderName);
    public function closeSpider();
}