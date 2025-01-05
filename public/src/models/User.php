<?php

class User{
    private $id;
    private $email;
    private $password;
    private $name;
    private $surname;
    private $role;

    public function __construct(string $email, string $password, string $name, string $surname, string $role = 'user'){
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->role = $role;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getPassword(): string{
        return $this->password;
    }

    public function getName(): string{ 
        return $this->name;
    }

    public function getSurname(): string{
        return $this->surname;
    }
        
    public function getRole(): string{
        return $this->role;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }
    
    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }
    
    public function setName(string $name) {
        $this->name = $name;
    }

    public function setSurname(string $surname) {
        $this->surname = $surname;
    }
}