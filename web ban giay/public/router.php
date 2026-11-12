<?php

declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$requestedFile = __DIR__ . (is_string($path) ? $path : '');
$publicDirectory = realpath(__DIR__);
$realFile = realpath($requestedFile);

if (
    $publicDirectory !== false
    && $realFile !== false
    && str_starts_with($realFile, $publicDirectory . DIRECTORY_SEPARATOR)
    && is_file($realFile)
    && !in_array(basename($realFile), ['index.php', 'router.php'], true)
) {
    return false;
}

require __DIR__ . '/index.php';
