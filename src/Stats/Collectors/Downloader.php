<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Stats\Collectors;


use BMamba\Traits\WithMagicFunction;

class Downloader
{
    use WithMagicFunction;

    public function handle(...$arguments) {
        $stats = $arguments[0][0];
        if($stats instanceof \GuzzleHttp\TransferStats) {
            $request = $stats->getRequest();
            $response = $stats->getResponse();
            $handleStats = $stats->getHandlerStats();

            $this->stats->incValue('downloader/request_count');
            $this->stats->incValue(sprintf('downloader/request_method_count/%s', $request->getMethod()));

            if ($stats->hasResponse()) {
                $this->stats->incValue('downloader/response_count');
                $this->stats->incValue('response_received_count');
                $this->stats->incValue(sprintf('downloader/response_status_count/%s', $response->getStatusCode()));
            }

            $this->stats->incValue('downloader/request_bytes', $stats->getHandlerStat('request_size'));
            $this->stats->incValue('downloader/response_bytes', $stats->getHandlerStat('download_content_length'));

        }
        
    }
}