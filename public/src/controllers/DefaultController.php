<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class DefaultController extends AppController{

    public function login(){
        $this->render('login');
    }

    public function registration(){
        $this->render('registration');
    }

    public function workouts() {
        session_start();
        $userRepository = new UserRepository();
        $currentUser = $userRepository->getUser($_SESSION['user_email']);

        return $this->render('workouts', ['currentUser' => $currentUser]);
    
    }

    public function home() {
        $this->render('home');
    }
}
