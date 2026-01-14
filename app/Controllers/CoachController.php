<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Services\CoachService;
use App\Services\AuthService;

class CoachController extends Controller{

// Private property to store the CoachService instance
private $coachService;
private $authService;

// Constructor with dependency injection and default value
public function __construct($coachService = null, $authService = null){
    $this->coachService = $coachService ?? new CoachService();
    $this->authService = $authService ?? new AuthService();
}
public function index(){
    $coachs = $this->coachService->getAllCoachs();
    $this->view('coach.index', ['coachs' => $coachs]);
}

public function show($id){
    $coach = $this->coachService->getCoachById($id);
    $this->view('coach.show', ['coach' => $coach]);
}


public function edit($id){
    if(!$this->authService->isAuthenticated() || !$this->authService->isCoach()){
        $this->redirect('/login');
        return;
    }
    $user = $this->authService->getUser();
    $coach = $this->coachService->getCoachById($user['id']);
    $this->view('coach.edit', ['coach' => $coach]);
}

public function update(){
    if(!$this->authService->isAuthenticated() || !$this->authService->isCoach()){
        $this->redirect('/login');
        return;
    }
    $user = $this->authService->getUser();
    $data = $_POST;

    $coachService = new CoachService();
    $coachService->updateProfile($user['id'], $data);
    $this->redirect('/coach/profile/edit');
}


}