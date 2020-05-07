<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Middlewares\DownloaderMiddlewares;


use BMamba\Middlewares\DownloaderMiddlewareManager;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Middleware;

class DownloaderStatsMiddleware extends DownloaderMiddlewareManager
{
    public function processRequest(...$params) {
        return Middleware::mapRequest(function (RequestInterface $request) use ($params) {
            $this->container['stats']->incValue('downloader/request_count');
            $this->container['stats']->incValue(sprintf('downloader/request_method_count/%s', $request->getMethod()));
            return $request;
        });
    }

    public function processResponse(...$params) {
        return Middleware::mapResponse(function (ResponseInterface $response) use ($params) {
            $this->container['stats']->incValue('downloader/response_count');
            $this->container['stats']->incValue(sprintf('downloader/response_status_count/%s', $response->status()));
            return $response;
        });
    }
}