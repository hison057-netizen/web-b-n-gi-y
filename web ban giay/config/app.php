<?php

declare(strict_types=1);

return [
    'name' => getenv('APP_NAME') !== false ? getenv('APP_NAME') : 'SoleMate',
    'env' => getenv('APP_ENV') !== false ? getenv('APP_ENV') : 'production',
    'debug' => filter_var(getenv('APP_DEBUG') ?: 'false', FILTER_VALIDATE_BOOLEAN),
    'base_url' => rtrim((string) (getenv('APP_BASE_URL') ?: ''), '/'),
];
