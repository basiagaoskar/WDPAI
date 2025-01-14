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

    public function home() {
        $this->render('home');
    }

    public function error($number) {
        $validErrors = [403, 404];
        $messages = [
            403 => "Oops! You are not allowed to access this page.",
            404 => "Oops! The page you are looking for does not exist."
        ];
    
        $message = $messages[$number] ?? "Oops! The page you are looking for does not exist.";
        return $this->render('errors', ['number' => $number, 'message' => $message]);
    }
}