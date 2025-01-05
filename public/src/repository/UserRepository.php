<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE email = :email
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
}