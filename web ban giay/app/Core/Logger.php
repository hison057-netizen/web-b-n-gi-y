<?php

declare(strict_types=1);

namespace App\Core;

final class Logger
{
    public static function error(string $message, string $logFile): void
    {
        $directory = dirname($logFile);

        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            error_log($message);
            return;
        }

        if (error_log($message . PHP_EOL, 3, $logFile) === false) {
            error_log($message);
        }
    }
}
