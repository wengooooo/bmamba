<?php
namespace BMamba\Contracts\Logger;


interface Logger
{
    public function log($level, $detail, array $context = []);
}