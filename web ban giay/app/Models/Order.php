<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Order extends Model
{
    protected string $table = 'orders';

    public function getRecent(int $limit = 5): array
    {
        $sql = "SELECT o.*, u.full_name as user_name
                FROM {$this->table} o
                LEFT JOIN users u ON o.user_id = u.id
                ORDER BY o.id DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getTotalRevenue(): float
    {
        $sql = "SELECT COALESCE(SUM(total_amount), 0) as revenue
                FROM {$this->table}
                WHERE payment_status = 'paid' OR order_status = 'completed'";
        $result = $this->queryOne($sql);
        return (float) ($result['revenue'] ?? 0);
    }
}
