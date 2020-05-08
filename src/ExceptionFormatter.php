<?php

declare(strict_types=1);

namespace Smarttly\ExceptionUtils;

use Throwable;

class ExceptionFormatter
{
    /** @var bool $traceEnabled */
    protected static $traceEnabled = true;

    /**
     * @param Throwable $e
     * @param array $defaultContext
     * @return array
     */
    public static function format(Throwable $e, array $defaultContext = []): array
    {
        return [
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => static::detectFile($e),
            'triggered' => static::detectTriggered($e),
            'context' => static::generateContext($e, $defaultContext),
        ] + ((static::$traceEnabled) ? ['trace' => static::generateTrace($e)] : []);
    }

    /**
     * @param Throwable $e
     * @return string
     */
    private static function generateTrace(Throwable $e): string
    {
        return $e->getTraceAsString();
    }

    /**
     * @param Throwable $e
     * @param array $defaultContext
     * @return array
     */
    private static function generateContext(Throwable $e, array $defaultContext): array
    {
        $context = method_exists($e, 'getContext') ? $e->getContext() : [];
        return $context + $defaultContext;
    }

    /**
     * @param Throwable $e
     * @return string
     */
    private static function detectFile(Throwable $e): string
    {
        return $e->getFile() . ':' . $e->getLine();
    }

    /**
     * @param Throwable $e
     * @return string
     */
    private static function detectTriggered(Throwable $e): string
    {
        $trace = $e->getTrace();

        if (!isset($trace[0])) {
            return '';
        }

        return ($trace[0]['class'] ?? '')
            . ($trace[0]['type'] ?? '')
            . (isset($trace[0]['function']) ? $trace[0]['function'] . '()' : '');
    }

    /**
     * @return void
     */
    public static function enableTrace(): void
    {
        static::$traceEnabled = true;
    }

    /**
     *
     * @return void
     */
    public static function disableTrace(): void
    {
        static::$traceEnabled = false;
    }
}
