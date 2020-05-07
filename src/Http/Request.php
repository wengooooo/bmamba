<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Http;

use GuzzleHttp\Psr7\Request as BaseRequest;
use BMamba\Contracts\Http\Request as RequestContract;
class Request extends BaseRequest implements RequestContract
{
    public $callback;
    public $meta;

    public function __construct(
        $method,
        $uri,
        $callback = 'parse',
        $meta = [],
        array $headers = [],
        $body = null,
        $version = '1.1'
    ) {
        $this->addCallBackToHeader($headers, $callback);
        $this->addMetaToHeader($headers, $meta);
        parent::__construct($method, $uri, $headers, $body, $version);
    }

    public function addCallBackToHeader(&$headers, $callback) {
        $headers['x-guzzle-callback'] = $callback;
    }

    public function addMetaToHeader(&$headers, $meta) {
        if(count($meta) > 0) {
            $headers['x-guzzle-meta'] = $meta;
        }

    }
}