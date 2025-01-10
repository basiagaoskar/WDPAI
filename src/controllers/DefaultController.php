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
}