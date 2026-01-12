<?php
namespace App\Services;

use App\Services\ServiceInterface;
use App\Models\User;
use App\Models\Coach;

class AuthService implements ServiceInterface
{
    public function register(array $data): array{
        $user = new User();

        if($user->findByEmail($data['email'])){
            throw new \Exception('Email already exists');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $userId = $user->create($data);

        if($data['role'] === 'coach'){
            $coach = new Coach();
            $coach->create(['user_id' => $userId]);
        }
        return $user->find($userId); // we are returning the user data in order to be used in the controller
    }


    public function login(string $email, string $password): ?array{
        $user = new User();
        $userData = $user->findByEmail($email);
        if(!$userData || !$user->verifyPassword($password, $userData['password'])){
            return null;
        }

        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_role'] = $userData['role'];
        $_SESSION['user_email'] = $userData['email'];

        return $userData;
    }


    public function getUser(): ?array{// this ? means that the function can return null
        if(!isset($_SESSION['user_id'])){
            return null ;
        }
        $user = new User();
        return $user->find($_SESSION['user_id']);
    }

    public function isAuthenticated(): bool{
        return isset($_SESSION['user_id']);
    }

    public function isCoach():bool{
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'coach'; 
    }

    public function isSportif():bool{
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'sportif';
    }

}