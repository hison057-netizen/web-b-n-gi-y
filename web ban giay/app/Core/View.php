<?php

declare(strict_types=1);

namespace App\Core;

use InvalidArgumentException;
use RuntimeException;
use Throwable;

final class View
{
    public function render(string $view, array $data = [], string $layout = 'layouts/store'): void
    {
        $viewFile = $this->resolve($view);

        extract($data, EXTR_SKIP);

        ob_start();

        try {
            require $viewFile;
            $content = ob_get_clean();
        } catch (Throwable $exception) {
            ob_end_clean();
            throw $exception;
        }

        require $this->resolve($layout);
    }

    public static function escape(string|int|float|null $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function asset(string $path): string
    {
        return APP_BASE_URL . '/assets/' . ltrim($path, '/');
    }

    public static function url(string $path = ''): string
    {
        return APP_BASE_URL . '/' . ltrim($path, '/');
    }

    private function resolve(string $name): string
    {
        if (!preg_match('#^[A-Za-z0-9_/-]+$#', $name)) {
            throw new InvalidArgumentException('Invalid view name.');
        }

        $basePath = APP_ROOT . '/app/Views/';
        $file = $basePath . $name . '.php';
        $realBasePath = realpath($basePath);
        $realFile = realpath($file);

        if ($realBasePath === false || $realFile === false || !str_starts_with($realFile, $realBasePath . DIRECTORY_SEPARATOR)) {
            throw new RuntimeException('The requested view does not exist.');
        }

        return $realFile;
    }
}
