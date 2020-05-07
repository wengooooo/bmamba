<?php
return [
    'BOT_NAME' => 'mamba',

    'CONCURRENT_REQUESTS' => 8,

    'COOKIES_ENABLED' => true,

    'STATS_CLASS' => '\BMamba\Stats\MemoryStatsCollector',
    'STATS_DUMP' => true,
    'STATS_COLLECTORS' => [
        'schedule' => 'BMamba\Stats\Collectors\Schedule',
        'scraper' => 'BMamba\Stats\Collectors\Scraper',
        'downloader' => 'BMamba\Stats\Collectors\Downloader',
        'retry' => 'BMamba\Stats\Collectors\Retry',
    ],

    'DEFAULT_REQUEST_HEADERS' => [
        'Accept' =>  'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language'  => 'en',
    ],

    'ENGINE' => '\BMamba\Core\ExecutionEngine',

    'DOWNLOAD_DELAY' => null,
    'DOWNLOAD_TIMEOUT' => 180,

    # 下载处理类
    'DOWNLOADER' => '\BMamba\Core\Downloader',
    'DOWNLOAD_DEBUG' => false,

    'DOWNLOAD_HANDLERS' => [],
    'DOWNLOAD_HANDLERS_BASE' => [
        'data' => 'BMamba\Downloader\Handlers\DataURIDownloadHandler',
        'file' => 'BMamba\Downloader\Handlers\FileDownloadHandler',
        'http' => 'BMamba\Downloader\Handlers\HTTPDownloadHandler',
        'https' => 'BMamba\Downloader\Handlers\HTTPDownloadHandler',
        's3' => 'BMamba\Downloader\Handlers\S3DownloadHandler',
        'ftp' => 'BMamba\Downloader\Handlers\FTPDownloadHandler',
    ],

    # 请求过滤器
    'DUPEFILTER_CLASS' => '\BMamba\Filters\RFPDupeFilter',

    'LOG_ENABLED' => true,

    'LOGSTATS_INTERVAL' => 60,

    'CONNECT_TIMEOUT' => 60,
    'READ_TIMEOUT' => 60,

    'SCHEDULER_DEBUG' => true,

    'REDIRECT_ENABLED' => true,
    'REDIRECT_MAX_TIMES' => 20, # firefox默认是20次
    'TRACK_REDIRECTS' => false,



    'REFERER_ENABLED' => true,
    'REFERRER_POLICY' => '',

    'RETRY_ENABLED' => true,
    'RETRY_TIMES' => 3,
    'RETRY_HTTP_CODES' => [500, 502, 503, 504, 522, 524, 408],

    'SCHEDULER' => '\BMamba\Core\Scheduler',
    # 基于磁盘的任务队列(后进先出)
    'SCHEDULER_DISK_QUEUE' => 'PickleLifoDiskQueue',
    # 基于内存的任务队列(后进先出)
    'SCHEDULER_MEMORY_QUEUE' => 'LifoMemoryQueue',
    # 优先级队列
    'SCHEDULER_PRIORITY_QUEUE' => 'PriorityQueue',

    # 爬虫加载类
    'SPIDER_LOADER_CLASS' => '\BMamba\Core\SpiderLoader',
    'SPIDER_MODULES' => [],
    'SPIDER_MIDDLEWARES' => [],
    'SPIDER_MIDDLEWARES_BASE' => [],

    'USER_AGENT' => 'Mamba Bot',

    'DOWNLOADER_MIDDLEWARES' => [
//        '\BMamba\Middlewares\DownloaderMiddlewares\EffectiveUrlMiddleware' => 100,
//        '\GuzzleHttp\PrepareBodyMiddleware' => 100,
//        '\GuzzleHttp\RedirectMiddleware' => 200,
//        '\GuzzleHttp\RetryMiddleware' => 300,
    ],
    'DOWNLOADER_MIDDLEWARES_BASE' => [
        '\BMamba\Middlewares\DownloaderMiddlewares\EffectiveUrlMiddleware' => 100,
        '\BMamba\Middlewares\DownloaderMiddlewares\UserAgentMiddleware' => 200,
        '\BMamba\Middlewares\DownloaderMiddlewares\MetaMiddleware' => 300,
        '\BMamba\Middlewares\DownloaderMiddlewares\RetryAgentMiddleware' => 400,
    ],

    'ITEM_PIPELINES' => [],
    'ITEM_PIPELINES_BASE' => [],
];