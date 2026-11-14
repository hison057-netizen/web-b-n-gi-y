<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        return $this->findBy('email', $email);
    }

    public function getCustomers(int $limit = 10): array
    {
        $sql = "SELECT u.id, u.full_name, u.email, u.phone, u.status, u.created_at,
                       COUNT(o.id) as total_orders
                FROM {$this->table} u
                LEFT JOIN orders o ON u.id = o.user_id
                GROUP BY u.id, u.full_name, u.email, u.phone, u.status, u.created_at
                ORDER BY u.id DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
