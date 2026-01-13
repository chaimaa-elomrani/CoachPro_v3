<?php
namespace App\Controllers;
use App\Core\Controller;


class AuthController extends Controller
{

public function showLogin(){
    $this->view("auth.login");
}


public function login(){
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    $authService = new \App\Services\AuthService() ;
    $user = $authService->login($email, $password);

    if($user){
        $this->redirect('/');
    }else{
        $this->view('auth.login',  ['error' => 'Invalid credentials']);
    }
}
    
public function showRegister(){
    return  $this->view('auth.register');
}

public function register(){
   
    $data = [
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'role' => $_POST['role'] ?? 'sportif'
    ];

    $authService = new \App\Services\AuthService() ;

    try{
        $authService->register($data);
        $this->redirect('/login');
    }catch(\Exception $e){
        $this->view('auth.register', ['error' => $e->getMessage()]);
    }
}

public function logout(){
    $authService = new \App\Services\AuthService() ;
    $authService->logout();
    $this->redirect('/login');
}

}