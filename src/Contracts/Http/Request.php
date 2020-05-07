<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Contracts\Http;


interface Request
{
    public function addCallBackToHeader(&$headers, $callback);
    public function addMetaToHeader(&$headers, $meta);
}