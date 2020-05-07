<?php
namespace BMamba\Middlewares\DownloaderMiddlewares;


use BMamba\Traits\WithMagicFunction;
use Closure;
use GuzzleHttp\Middleware;

class RetryAgentMiddleware {

    use WithMagicFunction;

    /**
     * retryDecider
     * 返回一个匿名函数, 匿名函数若返回false 表示不重试，反之则表示继续重试
     * @return Closure
     */
    protected function decider()
    {
        return function (
            $retries,
            $request,
            $response = null,
            $exception = null
        ) {

            // 超过最大重试次数，不再重试
            if ($retries >= $this->container['config']->get('settings.RETRY_TIMES')) {
                return false;
            }

            // 请求失败，继续重试
//            if ($exception instanceof ConnectException || $exception instanceof RequestException) {
//                $this->container['stats']->incValue('retry/count');
//                $this->container['stats']->incValue(sprintf('retry/reason_count/%s', str_replace('\\', '.', get_class($exception))));
//                return true;
//            } else if($exception != null) {
//                $this->container['stats']->incValue(sprintf('retry/reason_count/%s', str_replace('\\', '.', get_class($exception))));
//            }

            if($exception != null) {
                $this->stats->retry('retry/count');
                $this->stats->retry(sprintf('retry/reason_count/%s', str_replace('\\', '.', get_class($exception))));
                return true;
            }

            if ($response) {
                // 如果请求有响应，但是状态码大于等于500，继续重试(这里根据自己的业务而定)
                if (in_array($response->getStatusCode(), $this->container['config']->get('settings.RETRY_HTTP_CODES'))) {
                    return true;
                }
            }

            return false;
        };
    }

    /**
     * 返回一个匿名函数，该匿名函数返回下次重试的时间（毫秒）
     * @return Closure
     */
    protected function delay() {
        return function ($numberOfRetries) {
            return 1000 * $numberOfRetries;
        };
    }


    public function __invoke(callable $handler)
    {
        $decider = $this->decider();
        $delay = $this->delay();

        return Middleware::retry($decider, $delay)($handler);

    }
}