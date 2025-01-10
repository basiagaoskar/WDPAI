<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository {
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        $userObj = new User(
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname'],
            $user['role']
        );
        $userObj->setId($user['id']);

        return $userObj;
    }

    public function createUser(User $user): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.users (email, password, name, surname) 
            VALUES (:email, :password, :name, :surname)
        ');

        $stmt->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindParam(':password', $user->getPassword(), PDO::PARAM_STR);
        $stmt->bindParam(':name', $user->getName(), PDO::PARAM_STR);
        $stmt->bindParam(':surname', $user->getSurname(), PDO::PARAM_STR);

        $stmt->execute();
    }

    public function getAllUsers(): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM users ORDER BY id ASC
        ');
        $stmt->execute();

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($row['email'], $row['password'], $row['name'], $row['surname'], $row['role']);
            $user->setId($row['id']);
            $users[] = $user;
        }

        return $users;
    }

    public function deleteUserByEmail(string $email): bool
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM users WHERE email = :email
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateUserRole($email, $role) {
        $stmt = $this->database->connect()->prepare('
        UPDATE users SET role = :role WHERE email = :email
        ');
        
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public function getProfileImage($email) {
        $stmt = $this->database->connect()->prepare('
            SELECT profile_picture 
            FROM user_profiles up
            JOIN users u ON up.user_id = u.id
            WHERE u.email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['profile_picture'];
    }

    public function getBio($email) {
        $stmt = $this->database->connect()->prepare('
            SELECT up.bio 
            FROM users u
            LEFT JOIN user_profiles up ON u.id = up.user_id
            WHERE u.email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['bio'] : null;
    }

    public function updateProfile($email, $name, $surname, $bio, $profileImage) {
        $conn = $this->database->connect();
        $conn->beginTransaction();
        
        try {
            $stmt = $conn->prepare('
                UPDATE users 
                SET name = :name, surname = :surname 
                WHERE email = :email
            ');
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $conn->prepare('
                UPDATE user_profiles 
                SET bio = :bio, profile_picture = :profileImage 
                WHERE user_id = (SELECT id FROM users WHERE email = :email)
            ');
            $stmt->bindParam(':bio', $bio, PDO::PARAM_STR);
            $stmt->bindParam(':profileImage', $profileImage, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            error_log("Failed to update profile: " . $e->getMessage());
            return false;
        }
    }
}