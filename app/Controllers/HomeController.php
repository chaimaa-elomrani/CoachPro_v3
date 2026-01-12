<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    /**
     * Display home page
     */
    public function index(): void
    {
        $data = [
            'title' => 'Welcome to CoachPro',
            'message' => 'This is the home page',
        ];

        $this->view('home.index', $data);
    }
}
