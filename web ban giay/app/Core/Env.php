<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class Env
{
    public static function load(string $path): void
    {
        if (!is_file($path)) {
            return;
        }

        if (!is_readable($path)) {
            throw new RuntimeException('The environment file exists but cannot be read.');
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES);

        if ($lines === false) {
            throw new RuntimeException('The environment file could not be loaded.');
        }

        foreach ($lines as $index => $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (!preg_match('/^([A-Za-z_][A-Za-z0-9_]*)\s*=\s*(.*)$/', $line, $matches)) {
                throw new RuntimeException('Invalid environment entry on line ' . ($index + 1) . '.');
            }

            $name = $matches[1];
            $value = trim($matches[2]);
            $firstCharacter = $value[0] ?? '';
            $lastCharacter = $value !== '' ? $value[strlen($value) - 1] : '';

            if (($firstCharacter === '"' && $lastCharacter === '"')
                || ($firstCharacter === "'" && $lastCharacter === "'")) {
                $value = substr($value, 1, -1);
            }

            if (getenv($name) === false) {
                putenv($name . '=' . $value);
                $_ENV[$name] = $value;
            }
        }
    }
}
