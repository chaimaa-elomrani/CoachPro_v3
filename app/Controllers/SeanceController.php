<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\SeanceService;
use App\Services\AuthService;
class SeanceController extends Controller
{

private $seanceService;
private $authService;
public function __construct($seanceService = null, $authService = null){
    $this->seanceService = $seanceService ?? new SeanceService();
    $this->authService = $authService ?? new AuthService();
}
    public function index()
    {
        $seances = $this->seanceService->getAllSeances();
        
        $this->view('seance.index', ['seances' => $seances]);
    }

    public function show($id)
    {
        $seance = $this->seanceService->getSeanceById($id);
        
        if (!$seance) {
            http_response_code(404);
            echo "Session not found";
            return;
        }

        $this->view('seance.show', ['seance' => $seance]);
    }

    // Coach-only methods
    public function create()
    {
        if (!$this->authService->isAuthenticated() || !$this->authService->isCoach()) {
            $this->redirect('/login');
            return;
        }

        $this->view('seance.create');
    }

    public function store()
    {
        if (!$this->authService->isAuthenticated() || !$this->authService->isCoach()) {
            $this->redirect('/login');
            return;
        }

        $user = $this->authService->getUser();
        $data = $_POST;
        
        $this->seanceService->createSeance($user['id'], $data);
        $this->redirect('/coach/seances');
    }


}
