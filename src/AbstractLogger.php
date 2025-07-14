<?php

namespace AdvancedLogger;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

/**
 * Implementação base do PSR-3 que outros loggers podem estender.
 * Oferece métodos como info(), error(), etc., convertendo-os para chamadas ao método log().
 */
abstract class AbstractLogger implements LoggerInterface
{
    /**
     * Níveis de log válidos (PSR-3).
     */
    protected const LEVELS = [
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::WARNING,
        LogLevel::NOTICE,
        LogLevel::INFO,
        LogLevel::DEBUG,
    ];

    /**
     * Verifica se um nível de log é válido.
     * @throws InvalidArgumentException
     */
    protected function validateLevel(string $level): void
    {
        if (!in_array($level, self::LEVELS, true)) {
            throw new InvalidArgumentException(
                sprintf('Nível de log inválido: "%s"', $level)
            );
        }
    }

    /**
     * Método principal (deve ser implementado pelas classes filhas).
     */
    abstract public function log($level, string|\Stringable $message, array $context = []): void;

    /**
     * Métodos de atalho (PSR-3):
     * - Convertem chamadas como info() para log() com o nível correspondente.
     */

    public function emergency(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function error(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function notice(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }
}