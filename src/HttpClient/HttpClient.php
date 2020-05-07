<?php

namespace BMamba\HttpClient;


use BMamba\Contracts\Container\CrawlerContainer;
use BMamba\Traits\WithMagicFunction;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use BMamba\Contracts\HttpClient\Client as ClientContract;
class HttpClient implements ClientContract
{
    use WithMagicFunction;

    protected $client;
    protected $container;

    public function __construct(CrawlerContainer $container)
    {
        $this->container = $container;
        $options = $this->configureDefaults();
        $this->client = new Client($options);
    }

    public function configureDefaults() {
        return [
            'handler' => $this->container['http.handler']->getHandler(),
            'on_stats' => function(TransferStats $stats) {
                $this->stats->downloader($stats);
            },
            'allow_redirects' => [
                'max'               => $this->config->get('settings.REDIRECT_ENABLED'),
                'protocols'         => ['http', 'https'],
                'strict'            => false,
                'referer'           => $this->config->get('settings.REFERER_ENABLED'),
                'track_redirects'   => $this->config->get('settings.TRACK_REDIRECTS'),
            ],
            'progress' => function($downloadTotal, $downloadedBytes, $uploadTotal, $uploadedBytes) {
                $this->container['log.stats']->log();
            },
            'http_errors'           => true,
            'decode_content'        => true,
            'verify'                => true,
            'delay'                 => $this->config->get('settings.DOWNLOAD_DELAY'),
            'read_timeout'          => $this->config->get('settings.READ_TIMEOUT'),
            'timeout'               => $this->config->get('settings.DOWNLOAD_TIMEOUT'),
            'cookies'               => $this->config->get('settings.COOKIES_ENABLED'),
            'connect_timeout'       => $this->config->get('settings.CONNECT_TIMEOUT'),
            'debug'                 => $this->config->get('settings.DOWNLOAD_DEBUG')
        ];
    }

    public function getClient() {
        return $this->client;
    }
}