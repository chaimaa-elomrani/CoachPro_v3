<?php 

namespace App\Models;

use App\Core\Model;

class Seance extends Model
{
    protected $table = 'seances';
    protected $primaryKey = 'id';

    public function findByCoachId(int $coachId): array{
        return $this->all(['coach_id' => $coachId]);
    }

    public function getAvailable(): array{
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE current_participants < max_participants AND date > NOW() ORDER BY date ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}