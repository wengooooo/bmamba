<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Contracts\Core;


interface Engine
{
    public function handleDownloaderOutput($index, $response);
    public function openSpider($spider, $startRequest);
    public function schedule($urls);
    public function download();
    public function start();
}