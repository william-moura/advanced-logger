<?php

namespace AdvancedLogger;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class Logger extends AbstractLogger
{
    public function __construct(
        private array $handlers = []
    ) {}

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        foreach ($this->handlers as $handler) {
            $handler->handle($level, $message, $context);
        }
    }
}