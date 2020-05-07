<?php

namespace BMamba\Middlewares\DownloaderMiddlewares;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MetaMiddleware
{
    public function processResponse() {
        return function (callable $handler) {
            return function (
                RequestInterface $request,
                array $options
            ) use ($handler) {

                $headers = $request->getHeaders();
                $orginRequest = $request;
                foreach($headers as $key => $value) {
                    if(stripos($key, 'x-guzzle') !== false) {
                        $request = $request->withoutHeader($key, $value);
                    }
                }

                $promise = $handler($request, $options);
                return $promise->then(
                    function (ResponseInterface $response) use ($orginRequest, $options) {
                        $headers = $orginRequest->getHeaders();
                        foreach($headers as $key => $value) {
                            if(stripos($key, 'x-guzzle') !== false) {
                                $response = $response->withHeader($key, $value);
                            }
                        }

                        return $response;
                    }
                );
            };
        };
    }

}