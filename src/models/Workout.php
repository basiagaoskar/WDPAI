<?php

class Workout {
    private $id;
    private $title;
    private $description;
    private $userId;
    private $image;

    public function __construct($id, $title, $description, $userId, $image) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->userId = $userId;
        $this->image = $image;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getImage() {
        return $this->image;
    }
}