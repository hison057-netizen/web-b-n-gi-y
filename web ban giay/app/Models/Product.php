<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    protected string $table = 'products';

    public function getFeatured(int $limit = 8): array
    {
        $sql = "SELECT p.*, 
                       MAX(b.name) as brand_name,
                       MIN(pv.price) as min_price,
                       MIN(pv.sale_price) as min_sale_price,
                       COALESCE(MAX(pi.image_url), '') as primary_image
                FROM {$this->table} p
                LEFT JOIN brands b ON p.brand_id = b.id
                LEFT JOIN product_variants pv ON p.id = pv.product_id AND pv.status = 'active'
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                WHERE p.status = 'active'
                GROUP BY p.id, p.brand_id, p.name, p.slug, p.description, p.status, p.created_at, p.updated_at
                ORDER BY p.id DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getLatest(int $limit = 8): array
    {
        return $this->getFeatured($limit);
    }

    public function getDetail(int|string $id): ?array
    {
        $sql = "SELECT p.*, b.name as brand_name,
                       COALESCE(pi.image_url, '') as primary_image
                FROM {$this->table} p
                LEFT JOIN brands b ON p.brand_id = b.id
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                WHERE p.id = :id AND p.status = 'active'
                LIMIT 1";

        return $this->queryOne($sql, ['id' => $id]);
    }

    public function getVariants(int|string $productId): array
    {
        $sql = "SELECT * FROM product_variants WHERE product_id = :id AND status = 'active' ORDER BY size ASC";
        return $this->query($sql, ['id' => $productId]);
    }

    public function getImages(int|string $productId): array
    {
        $sql = "SELECT * FROM product_images WHERE product_id = :id ORDER BY sort_order ASC";
        return $this->query($sql, ['id' => $productId]);
    }

    public function getAdminList(int $limit = 20): array
    {
        $sql = "SELECT p.*, 
                       MAX(b.name) as brand_name,
                       COUNT(pv.id) as variant_count,
                       COALESCE(SUM(pv.stock_quantity), 0) as total_stock,
                       MIN(pv.price) as min_price
                FROM {$this->table} p
                LEFT JOIN brands b ON p.brand_id = b.id
                LEFT JOIN product_variants pv ON p.id = pv.product_id
                GROUP BY p.id, p.brand_id, p.name, p.slug, p.description, p.status, p.created_at, p.updated_at
                ORDER BY p.id DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
