<?php

namespace BMamba\Contracts\Stats;


interface StatsCollector
{
    public function incValue($key, $count=1, $start=0);
    public function getValue($key, $start=0);
    public function get($key, $default);
    public function dumps();
}