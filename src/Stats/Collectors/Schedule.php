<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Stats\Collectors;


use BMamba\Traits\WithMagicFunction;

class Schedule
{
    use WithMagicFunction;

    public function handle(...$arguments) {
        $this->stats->incValue($arguments[0][0]);
    }
}