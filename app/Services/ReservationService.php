<?php
namespace APP\Services;

use App\Services\ServiceInterface;
use App\Models\Reservations;
use App\Models\Seance;


class ReservationService implements ServiceInterface{
    public function createReservation(int $sportifId, int $seanceId):int{
        
        $reservation = new Reservations(); 
        $seance = new Seance(); 

        $seanceData =$seance->find($seanceId); 
        if (!$seanceData) {
            throw new \Exception('Session not found');
        }

        if($seanceData['current_participants'] >= $seanceData['max_participants']){
            throw new \Exception('Session is full');
        }

        if($reservation->hasReservation($sportifId, $seanceId)){
            throw new \Exception('you already booked this session');
        }

          $reservationId = $reservation->create([
            'sportif_id' => $sportifId,
            'seance_id' => $seanceId,
            'status' => 'confirmed'
        ]);
        //updating the count of participants 
        $seance->update($seanceId, [
            'current_participants' => $seanceData['current_participants'] + 1
        ]);

        return $reservationId ;

    }


    public function getSpotifReservations(int $sportifId): array{
        $reservations =  new Reservations();
        return $reservations->findBySportifId($sportifId);  
    }

    public function cancelReservation(int $reservationId , int $sportifId):int{
        $reservation = new Reservations();
        $reservationData = $reservation->find($reservationId);
        
        if (!$reservationData || $reservationData['sportif_id'] != $sportifId) {
            return false;
        }

        $reservation->update($reservationId, ['status' => 'cancelled']);

        // decrease session participants 
        $seance = new Seance();
        $seanceData = $seance->find($reservationData['seance_id']);
        $seance->update($reservationData['seance_id'], [
            'current_participants' => max(0, $seanceData['current_participants'] - 1)
        ]);
        return true ;
    }

    public function getCoachReservations(int $coachId) : array{
        $reservation = new Reservations();
        $stmt = $reservation->db->prepare("
        SELECT r.*, s.title, s.date, u.email as sportif_email
        FROM reservations r
        INNER JOIN seances s ON r.seance_id = s.id
        INNER JOIN users u ON r.sportif_id = u.id
        WHERE s.coach_id = :coach_id
        ORDER BY r.created_at DESC
    ");
    $stmt->execute(['coach_id' => $coachId]);
    return $stmt->fetchAll();    }
}