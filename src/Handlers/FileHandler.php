<?php

namespace AdvancedLogger\Handlers;

class FileHandler
{
    public function __construct(private string $filePath) {}

    public function handle(string $level, string $message, array $context = []): void
    {
        $logEntry = sprintf(
            "[%s] %s: %s %s\n",
            date('Y-m-d H:i:s'),
            strtoupper($level),
            $message,
            json_encode($context)
        );

        file_put_contents($this->filePath, $logEntry, FILE_APPEND);
    }
}