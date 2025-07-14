<?php

use AdvancedLogger\Logger;
use AdvancedLogger\Handlers\FileHandler;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public function testLogToFile()
    {
        $logFile = __DIR__ . '/test.log';
        $logger = new Logger([new FileHandler($logFile)]);
        $logger->info('Teste de log', ['user' => 'admin']);

        $this->assertFileExists($logFile);
        $content = file_get_contents($logFile);
        $this->assertStringContainsString('Teste de log', $content);
    }
}