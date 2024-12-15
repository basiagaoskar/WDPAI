<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController {
    public function login() {
        if($this->isPost()) {

            $user = new User('chillguy@gmail.com', 'admin', 'Kanye', 'East');
            
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
        
            if (empty($email) || empty($password)) {
                return $this->render('login', ['messages' => ['Please fill in all fields']]);
            }
            
            if ($user->getEmail() !== $email) {
                return $this->render('login', ['messages' => ['user with this email does not exist']]);
            }
        
            if ($user->getPassword() !== $password) {
                return $this->render('login', ['messages'=> ['Wrong password!']]);
            }
            
            header("Location: /workouts");
            exit;
        }
        return $this->render('login');

    }
}