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
        
            if (!password_verify($password, $user->getPassword())) {
                return $this->render('login', ['messages'=> ['Wrong password!']]);
            }
            
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_email'] = $user->getEmail();
            $_SESSION['user_id'] = $user->getId();

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

    public function registration() {
        if ($this->isPost()) {
            $name = $_POST["name"] ??"";
            $surname = $_POST["surname"] ??"";
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm-password'] ?? '';

            $userRepository = new UserRepository();

            if ($userRepository->getUser($email)) {
                return $this->render('registration', ['messages' => ['User already exists!']]);
            }

            if (empty($email) || empty($password) || empty($confirmPassword)) {
                return $this->render('registration', ['messages' => ['Please fill in all fields!']]);
            }

            if ($password !== $confirmPassword) {
                return $this->render('registration', ['messages' => ['Passwords do not match!']]);
            }

            if (!$this->isStrongPassword($password)) {
                return $this->render('registration', ['messages' => ['Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character!']]);
            }

            $user = new User($email, password_hash($password, PASSWORD_DEFAULT), $name, $surname);
            $userRepository->createUser($user);

            session_start();
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_email'] = $user->getEmail();

            header("Location: /login");
            exit;
        }

        return $this->render('registration');
    }

    private function isStrongPassword($password) {
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        return preg_match($pattern, $password);
    }
}