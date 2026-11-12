<?php

declare(strict_types=1);

namespace App\Core;

use Throwable;

final class ErrorHandler
{
    public static function register(string $logFile): void
    {
        set_exception_handler(static function (Throwable $exception) use ($logFile): void {
            $statusCode = $exception instanceof HttpException ? $exception->statusCode : 500;
            $message = sprintf(
                "[%s] %s in %s:%d",
                date(DATE_ATOM),
                $exception::class . ': ' . $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine()
            );

            Logger::error($message, $logFile);
            http_response_code($statusCode);

            if (APP_DEBUG && APP_ENV === 'development') {
                echo '<!doctype html><html lang="vi"><meta charset="utf-8"><title>Lỗi ứng dụng</title>';
                echo '<body style="font:16px system-ui,sans-serif;padding:32px;color:#243047">';
                echo '<h1>Lỗi ứng dụng</h1><pre>' . View::escape($exception->getMessage()) . '</pre></body></html>';
                return;
            }

            try {
                (new View())->render($statusCode === 404 ? 'errors/404' : 'errors/500');
            } catch (Throwable $renderException) {
                Logger::error(
                    '[' . date(DATE_ATOM) . '] Error page rendering failed: ' . $renderException->getMessage(),
                    $logFile
                );
                echo 'Đã xảy ra lỗi máy chủ. Vui lòng thử lại sau.';
            }
        });
    }
}
