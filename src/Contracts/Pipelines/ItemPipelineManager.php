<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Contracts\Pipelines;


interface ItemPipelineManager
{
    public function processItem($item);
}