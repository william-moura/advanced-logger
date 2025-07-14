<?php

namespace AdvancedLogger\Handlers;

use Psr\Log\LogLevel;
use InvalidArgumentException;
use GuzzleHttp\Client;

/**
 * Handler to send logs to Telegram via Bot API
 */
class TelegramHandler
{
    private Client $httpClient;
    private string $botToken;
    private string $chatId;
    private string $minimumLevel;

    /**
     * @param string $botToken Telegram Bot Token (from @BotFather)
     * @param string $chatId   Target chat ID (number or @channel)
     * @param string $minimumLevel Minimum log level to trigger this handler (default: debug)
     */
    public function __construct(
        string $botToken,
        string $chatId,
        string $minimumLevel = LogLevel::DEBUG
    ) {
        $this->botToken = $botToken;
        $this->chatId = $chatId;
        $this->setMinimumLevel($minimumLevel);
        $this->httpClient = new Client([
            'base_uri' => 'https://api.telegram.org',
            'timeout'  => 2.0,
        ]);
    }

    /**
     * Set minimum log level
     * @throws InvalidArgumentException
     */
    public function setMinimumLevel(string $level): void
    {
        $validLevels = [
            LogLevel::DEBUG,
            LogLevel::INFO,
            LogLevel::NOTICE,
            LogLevel::WARNING,
            LogLevel::ERROR,
            LogLevel::CRITICAL,
            LogLevel::ALERT,
            LogLevel::EMERGENCY,
        ];

        if (!in_array($level, $validLevels)) {
            throw new InvalidArgumentException(
                "Invalid log level: {$level}. Valid levels are: " . implode(', ', $validLevels)
            );
        }

        $this->minimumLevel = $level;
    }

    /**
     * Handle the log record
     */
    public function handle(string $level, string $message, array $context = []): void
    {
        if (!$this->shouldHandle($level)) {
            return;
        }

        $formattedMessage = $this->formatMessage($level, $message, $context);

        try {
            $this->sendToTelegram($formattedMessage);
        } catch (\Exception $e) {
            // Fail silently or log to error log
            error_log("TelegramHandler failed: " . $e->getMessage());
        }
    }

    /**
     * Check if the handler should process this log level
     */
    private function shouldHandle(string $level): bool
    {
        $levels = [
            LogLevel::DEBUG => 0,
            LogLevel::INFO => 1,
            LogLevel::NOTICE => 2,
            LogLevel::WARNING => 3,
            LogLevel::ERROR => 4,
            LogLevel::CRITICAL => 5,
            LogLevel::ALERT => 6,
            LogLevel::EMERGENCY => 7,
        ];

        return $levels[$level] >= $levels[$this->minimumLevel];
    }

    /**
     * Format the log message for Telegram
     */
    private function formatMessage(string $level, string $message, array $context): string
    {
        $levelEmoji = [
            LogLevel::DEBUG => '🔍',
            LogLevel::INFO => 'ℹ️',
            LogLevel::NOTICE => '📢',
            LogLevel::WARNING => '⚠️',
            LogLevel::ERROR => '❌',
            LogLevel::CRITICAL => '🔥',
            LogLevel::ALERT => '🚨',
            LogLevel::EMERGENCY => '💣',
        ][$level] ?? '📌';

        $text = "{$levelEmoji} *[{$level}]* {$message}";

        if (!empty($context)) {
            $text .= "\n\n`" . json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "`";
        }

        return $text;
    }

    /**
     * Send message to Telegram
     */
    private function sendToTelegram(string $message): void
    {
        $response = $this->httpClient->post("/bot{$this->botToken}/sendMessage", [
            'form_params' => [
                'chat_id' => $this->chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
                'disable_notification' => $this->shouldMuteNotification(),
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException("Telegram API error: " . $response->getBody());
        }
    }

    /**
     * Mute notifications for non-critical logs
     */
    private function shouldMuteNotification(): bool
    {
        return in_array($this->minimumLevel, [
            LogLevel::DEBUG,
            LogLevel::INFO,
            LogLevel::NOTICE,
        ], true);
    }
}