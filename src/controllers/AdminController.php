<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class AdminController extends AppController{
    
    private function checkPermission(array $allowedRoles): bool {
        if (!isset($_SESSION['loggedin']) || !isset($_SESSION['user_email'])) {
            return false;
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUser($_SESSION['user_email']);

        return in_array($user->getRole(), $allowedRoles);
    }

    public function adminPanel() {
        if (!$this->checkPermission(['admin'])) {
            header('Location: /error/403');
            exit;
        }
    
        $userRepository = new UserRepository();
        $users = $userRepository->getAllUsers();
        $currentUser = $userRepository->getUser($_SESSION['user_email']);
        
        return $this->render('main/adminPanel', ['users' => $users, 'currentUser' => $currentUser]);
        
    }
    
    public function deleteUser()
    {
        if (!isset($_POST['email'])) {
            header('Location: /admin-panel?error=Missing Email');
            exit;
        }

        $email = $_POST['email'];
        $userRepository = new UserRepository();

        $user = $userRepository->getUser($email);

        if (!$user) {
            header('Location: /adminPanel?error=User Not Found');
            exit;
        }

        if ($userRepository->deleteUserByEmail($email)) {
            header('Location: /adminPanel?message=User Deleted Successfully');
        } else {
            header('Location: /adminPanel?error=Delete Failed');
        }
        exit;
    }
    
    public function changeRole() {
        if (!$this->checkPermission(['admin'])) {
            header('Location: /error/403');
            exit;
        }
    
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? '';
    
        $userRepository = new UserRepository();
        $user = $userRepository->getUser($email);

        if (!$user) {
            header('Location: /adminPanel?error=User Not Found');
            exit;
        }

        if ($userRepository->updateUserRole($email, $role)) {
            header('Location: /adminPanel?message=Role Changed Successfully');
        } else {
            header('Location: /adminPanel?error=Role Change Failed');
        }
        exit;
    }
}