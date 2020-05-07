<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Http;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response as BaseResponse;
use BMamba\Contracts\Http\Response as ResponseContract;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

class Response extends BaseResponse implements ResponseContract
{
    public $callback;
    public $meta;
    public $dom;

    public function __construct($response) {
        $status = $response->getStatusCode();
        $headers = $response->getHeaders();
        $body = $response->getBody();
        $version = $response->getProtocolVersion();
        $reason = $response->getReasonPhrase();
        parent::__construct($status, $headers, $body, $version, $reason);

        $this->callback = current($response->getHeader("x-guzzle-callback"));
        $this->meta = $response->getHeader("x-guzzle-meta");
    }

    public function getBodyContents() {
        $this->getBody()->rewind();
        $contents = $this->getBody()->getContents();
        $this->getBody()->rewind();

        return $contents;
    }

    public function getCurrentUrl() {
        return current($this->getHeader('x-guzzle-effective-url'));
    }

    public function getDom() {
        if(!$this->dom) {
            $this->dom = new DomCrawler($this->getBodyContents(), $this->getCurrentUrl());
        }

        return $this->dom;
    }

    public function css($query) : \Symfony\Component\DomCrawler\Crawler{
        return $this->getDom()->filter($query);
    }

    public function xpath($query) {
        return $this->getDom()->filterXPath($query);
    }

    public function __toString() {
        return $this->getBodyContents();
    }

//    public static function buildFromPsrResponse(ResponseInterface $response) {
//        return new static(
//            $response->getStatusCode(),
//            $response->getHeaders(),
//            $response->getBody(),
//            $response->getProtocolVersion(),
//            $response->getReasonPhrase()
//        );
//    }
}