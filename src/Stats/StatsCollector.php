<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Stats;


use BMamba\Contracts\Container\CrawlerContainer;
use BMamba\Stats\Collectors\Schedule;
use BMamba\Traits\WithMagicFunction;
use \BMamba\Contracts\Stats\StatsCollector as StatsCollectorContract;
class StatsCollector implements StatsCollectorContract
{
    use WithMagicFunction;

    protected $dump;
    protected $container;
    protected static $stats = [];

    public function __construct(CrawlerContainer $container)
    {
        $this->container = $container;
        $this->dump = $container['config']->get("settings.STATS_DUMP");
    }

    public function incValue($key, $count=1, $start=0) {
        self::$stats[$key] = $this->get($key, $start) + $count;
    }

    public function getValue($key, $start=0) {
        return $this->get($key, $start);
    }

    public function get($key, $default) {
        return \array_key_exists($key, self::$stats) ? self::$stats[$key] : $default;
    }


    public function dumps() {
        if ($this->dump) {
            $this->container['log']->info(['component' => get_class($this), 'message' => sprintf('Dumping BMamba stats: %s', $this->container['log']->formatKeyArray(self::$stats))]);
        }
    }

    public function __call($name, $arguments) {
        $object = $this->container->make($this->config->get('settings.STATS_COLLECTORS')[$name]);
        $object->handle($arguments);
    }
}