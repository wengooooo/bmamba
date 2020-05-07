<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Contracts\HttpClient;


interface Client
{
    public function configureDefaults();
    public function getClient();

}