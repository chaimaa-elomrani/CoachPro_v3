<?php
namespace App\Models;

use App\Core\Model;

class Coach extends Model
{
    protected $table = 'coachs';
    protected $primaryKey = 'id';

    public function findByUserId(int $userId): ?array{
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = :user_id");
        $stmt->execute([
            'user_id' => $userId
        ]);
        return $stmt->fetch() ?: null;
    }

    public function findWithUser(int $id): ?array{
        $stmt = $this->db->prepare("SELECT c.*, u.email FROM {$this->table} c INNER JOIN users u ON c.user_id = u.id WHERE c.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
}