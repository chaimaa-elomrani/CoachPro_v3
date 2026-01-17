<?php 

namespace App\Controllers;
use App\Controllers\Controller;

class ReservationsController extends Controller{
    public function index(){
        $authService = new \App\Services\AuthService();
        if(!$authService->isAuthenticated()){
            $this->redirect('/login');
            return;
        }

        $user =$authService->getUser();
        $reservationsService = new \App\Services\ReservationService();
        $reservations = $reservationsService->getSpotifReservations($user['id']);
        $this->view('reservation.index', ['reservations' => $reservations]);
    }

    public function store()
    {
        $authService = new \App\Services\AuthService();
        if (!$authService->isAuthenticated()) {
            $this->redirect('/login');
            return;
        }

        $user = $authService->getUser();
        $seanceId = $_POST['seance_id'] ?? 0;

        $reservationService = new \App\Services\ReservationService();
        
        try {
            $reservationService->createReservation($user['id'], $seanceId);
            $this->redirect('/reservations');
        } catch (\Exception $e) {
            // Handle error
            $this->redirect('/seances');
        }
    }

    public function destroy($id)
    {
        $authService = new \App\Services\AuthService();
        if (!$authService->isAuthenticated()) {
            $this->redirect('/login');
            return;
        }

        $user = $authService->getUser();
        $reservationService = new \App\Services\ReservationService();
        $reservationService->cancelReservation($id, $user['id']);

        $this->redirect('/reservations');
    }
}