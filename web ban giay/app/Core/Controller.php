<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $data = [], string $layout = 'layouts/store'): void
    {
        (new View())->render($view, $data, $layout);
    }
}
