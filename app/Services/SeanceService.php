<?php

namespace App\Services;
use App\Services\ServiceInterface;
use App\Models\Seance;

class SeanceService implements ServiceInterface{
    public function getAllSeances(){
        $seance = new Seance();
        return $seance->getAvailable();
    }

    public function getSeancesById(int $id): ?array{
        $seance = new Seance();
        return $seance->find($id);
    }

    public function createSeance(int $coachId, array $data):int{
        $seance = new Seance();
        $data['coach_id'] = $coachId;
        $data['current_participants'] = 0;
        return $seance->create($data);
    }

    public function updateSeance(int $seanceId):bool {
        $seance = new Seance(); 
        return $seance->delete($seanceId);
    }

    public function getSeanceByCoach(int $coachId): array{
        $seance = new Seance();
        return $seance->findByCoachId( $coachId );
    }
}