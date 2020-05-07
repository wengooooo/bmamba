<?php
/**
 * This file is part of the wengo/basesdk.
 *
 * (c) basesdk <398711943@qq.com>
 *
 */

namespace BMamba\Logger;


final class DefaultContextLogger implements \Psr\Log\LoggerInterface
{
    use \Psr\Log\LoggerTrait;

    private $logger;
    private $context = [];

    public function __construct(\Psr\Log\LoggerInterface $logger, array $context = [])
    {
        $this->logger = $logger;
        $this->context = $context;
    }

    public function log($level, $message, array $context = array())
    {
        $this->logger->log($level, $message, $this->context+$context);
    }
}