<?php
namespace App\Models;

use App\Core\Model;

class Reservations extends Model
{
    protected $table = 'reservations';
    protected $primaryKey = 'id';


    public function findBySportifId(int $sportifId): array{
        return $this->all(['sportif_id => $sportifId']);
    }


    public function findBySeanceId(int $seanceId): array{
        return $this->all(['seance_id' => $seanceId]);
    }

    public function hasReservation(int $sportifId, int $seanceId):bool{
        $stmt = $this->db->prepare("SELECT COUNT(*) as count 
        FROM {$this->table} WHERE sportif_id = :sportif_id AND seance_id = :seance_id AND status != 'cancelled'"); 
        $stmt->execute(['sportif_id' => $sportifId, 'seance_id' => $seanceId]);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
}