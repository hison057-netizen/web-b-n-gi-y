<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    protected string $table = 'categories';

    public function getActive(): array
    {
        return $this->where('status', 'active');
    }

    public function getWithCount(): array
    {
        $sql = "SELECT c.*, COUNT(pc.product_id) as product_count
                FROM {$this->table} c
                LEFT JOIN product_categories pc ON c.id = pc.category_id
                WHERE c.status = 'active'
                GROUP BY c.id, c.parent_id, c.name, c.slug, c.status
                ORDER BY c.name ASC";

        return $this->query($sql);
    }
}
