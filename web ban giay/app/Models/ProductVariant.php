<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class ProductVariant extends Model
{
    protected string $table = 'product_variants';

    public function getByProduct(int|string $productId): array
    {
        return $this->where('product_id', $productId);
    }

    public function getTotalStock(): int
    {
        $sql = "SELECT COALESCE(SUM(stock_quantity), 0) as total FROM {$this->table} WHERE status = 'active'";
        $result = $this->queryOne($sql);
        return (int) ($result['total'] ?? 0);
    }
}
