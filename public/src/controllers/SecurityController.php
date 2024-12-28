<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController {
    public function login() {
        if($this->isPost()) {

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $userRepository = new UserRepository();
            $user = $userRepository->getUser($email);

            if(!$user) {
                return $this->render('login', ['messages' => ['User does not exist!']]);

            }
        
            if (empty($email) || empty($password)) {
                return $this->render('login', ['messages' => ['Please fill in all fields!']]);
            }
            
            if ($user->getEmail() !== $email) {
                return $this->render('login', ['messages' => ['User with this email does not exist!']]);
            }
        
            if ($user->getPassword() !== $password) {
                return $this->render('login', ['messages'=> ['Wrong password!']]);
            }
            
            session_start();
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_email'] = $user->getEmail();

            header("Location: /workouts");
            exit;
        }
        return $this->render('login');

    }
    public function logout() {
        session_start();
        session_unset();
        session_destroy();

        header("Location: /login");
        exit;
    }
}