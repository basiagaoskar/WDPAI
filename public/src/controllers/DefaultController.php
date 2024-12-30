<?php

require_once 'AppController.php';

class DefaultController extends AppController{

    public function login(){
        $this->render('login');
    }

    public function registration(){
        $this->render('registration');
    }

    public function workouts() {
        $this->render('workouts');
    }

    public function home() {
        $this->render('home');
    }
}
