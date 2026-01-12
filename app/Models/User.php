<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';


    public function findByEmail(string $email): ?array{
        $stmt  = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute([
            'email' => $email
        ]);
        return $stmt->fetch() ?: null;
    }

    public function verifyPassword(string $password, string $hash): bool{
        return password_verify($password, $hash);
    }
}