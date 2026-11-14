<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Brand extends Model
{
    protected string $table = 'brands';

    public function getActive(): array
    {
        return $this->where('status', 'active');
    }
}
