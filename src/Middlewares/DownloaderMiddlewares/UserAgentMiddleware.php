<?php
namespace BMamba\Middlewares\DownloaderMiddlewares;


use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UserAgentMiddleware {
    public function processRequest(...$params) {
        return Middleware::mapRequest(function (RequestInterface $request) use ($params) {
            return $request->withHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36');
//            return $request->withHeader('User-Agent', \Campo\UserAgent::random([
//                'os_type' => 'Windows',
//                'device_type' => 'Desktop'
//            ]));
        });
    }
//
    public function processResponse(...$params) {
        return Middleware::mapResponse(function (ResponseInterface $response) use ($params) {
            return $response->withHeader('X-Foo1', 123);
        });
    }

}