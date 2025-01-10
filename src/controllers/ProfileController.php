<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class ProfileController extends AppController {
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/public/uploads/';

    private $userRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function updateProfile() {
        if ($this->isPost()) {
            $email = $_SESSION['user_email'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $bio = $_POST['bio'];
            
            $currentUser = $this->userRepository->getUser($email);
            $profileImage = null;

            if (isset($_FILES['profileImage']) && is_uploaded_file($_FILES['profileImage']['tmp_name']) && $this->validate($_FILES['profileImage'])) {
                $extension = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
                $profileImage = $currentUser->getId() . '.' . $extension;
                $targetPath = dirname(__DIR__, 2) . self::UPLOAD_DIRECTORY . $profileImage;
                
                if (!move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetPath)) {
                    header('Location: /profile?error=Failed to upload file');
                    exit();
                }
            } else {
                $profileImage = $this->userRepository->getProfileImage($email);
            }

            if ($this->userRepository->updateProfile($email, $name, $surname, $bio, $profileImage)) {
                header('Location: /profile?error=Profile updated successfully');
                exit();
            } else {
                header('Location: /profile?error=Failed to update profile' );
                exit();
            }
        } else {    
            header('Location: /profile?error=Invalid request method');
            exit();
        }
    }

    private function validate(array $file): bool {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            header('Location: /profile?error=File is too large for destination file system.');
            exit();
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            header('Location: /profile?error=File type is not supported.');
            exit();
        }
        return true;
    }
}