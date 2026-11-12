<?php

declare(strict_types=1);

use App\Core\Env;
use App\Core\ErrorHandler;

define('APP_ROOT', __DIR__);

require_once APP_ROOT . '/app/Core/Env.php';

Env::load(APP_ROOT . '/.env');

$appConfig = require APP_ROOT . '/config/app.php';

define('APP_NAME', $appConfig['name']);
define('APP_ENV', $appConfig['env']);
define('APP_DEBUG', $appConfig['debug']);
define('APP_BASE_URL', $appConfig['base_url']);

$composerAutoloader = APP_ROOT . '/vendor/autoload.php';

if (is_file($composerAutoloader)) {
    require_once $composerAutoloader;
} else {
    spl_autoload_register(static function (string $class): void {
        $prefix = 'App\\';

        if (!str_starts_with($class, $prefix)) {
            return;
        }

        $relativeClass = substr($class, strlen($prefix));
        $file = APP_ROOT . '/app/' . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

        if (is_file($file)) {
            require_once $file;
        }
    });
}

ErrorHandler::register(APP_ROOT . '/storage/logs/app.log');
