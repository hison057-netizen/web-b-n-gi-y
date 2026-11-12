<?php

declare(strict_types=1);

namespace App\Core;

use InvalidArgumentException;

final class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    private function add(string $method, string $path, array $handler): void
    {
        if (!isset($handler[0], $handler[1]) || !is_string($handler[0]) || !is_string($handler[1])) {
            throw new InvalidArgumentException('Route handlers must be a controller class and method.');
        }

        $this->routes[$method][$this->normalizePath($path)] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $requestPath = parse_url($uri, PHP_URL_PATH);

        if (!is_string($requestPath)) {
            throw new HttpException(400, 'Invalid request path.');
        }

        $basePath = parse_url(APP_BASE_URL, PHP_URL_PATH);
        $basePath = is_string($basePath) ? rtrim($basePath, '/') : '';

        if ($basePath !== '' && ($requestPath === $basePath || str_starts_with($requestPath, $basePath . '/'))) {
            $requestPath = substr($requestPath, strlen($basePath)) ?: '/';
        }

        $path = $this->normalizePath($requestPath);
        $handler = $this->routes[strtoupper($method)][$path] ?? null;

        if ($handler === null) {
            http_response_code(404);
            (new View())->render('errors/404');
            return;
        }

        [$controllerClass, $action] = $handler;

        if (!class_exists($controllerClass)) {
            throw new HttpException(500, 'The requested route is not configured correctly.');
        }

        $controller = new $controllerClass();

        if (!is_callable([$controller, $action])) {
            throw new HttpException(500, 'The requested route is not configured correctly.');
        }

        $controller->{$action}();
    }

    private function normalizePath(string $path): string
    {
        $path = '/' . trim($path, '/');

        return $path === '//' ? '/' : $path;
    }
}
