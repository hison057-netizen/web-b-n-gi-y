<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Core\Router;

return static function (Router $router): void {
    $router->get('/', [HomeController::class, 'index']);
    $router->get('/products', [ProductController::class, 'index']);
    $router->get('/product', [ProductController::class, 'detail']);
    $router->get('/admin', [HomeController::class, 'admin']);
    $router->get('/admin/products', [ProductController::class, 'adminIndex']);
};
