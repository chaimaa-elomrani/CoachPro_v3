<?php 
namespace App\Services;

use App\Services\ServiceInterface;
use App\Models\Coach;
use App\Models\Seance;
class CoachService implements ServiceInterface
{
    public function getAllCoachs(): array{
        $coach = new Coach();
        return $coach->all();
    }


    public function getCoachById(int $id): ?array{
        $coach = new Coach();
        return $coach->findWithUser($id);
    }

    public function updateProfile(int $coachId, array $data): bool{
        $coach = new Coach();
        return $coach->update($coachId, $data);
    }


    public function deleteCoachById(int $id): bool{
        $coach = new Coach();
        return $coach->delete($id);
    }

    public function getCoachSeances(int $coachId): array{
        $seance = new Seance();
        return $seance->findByCoachId($coachId);
    }
}