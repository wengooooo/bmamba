<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Middlewares\DownloaderMiddlewares;

use Closure;
use GuzzleHttp\Middleware;
use GuzzleHttp\TransferStats;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
class LoggerMiddleware
{
    public function processResponse() {
        return Middleware::mapResponse(function (ResponseInterface $response) {
            $this->handleSuccess($response);
            $this->handleFailure($response);
        });

    }

    /**
     * Returns a function which is handled when a request was successful.
     *
     * @param RequestInterface $request
     * @param array $options
     * @return Closure
     */
    private function handleSuccess($response)
    {

    }

    /**
     * Returns a function which is handled when a request was rejected.
     *
     * @param RequestInterface $request
     * @param array $options
     * @return Closure
     */
    private function handleFailure($response)
    {

    }
}