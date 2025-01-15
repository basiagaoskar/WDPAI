<?php

class Exercise {
    private $id;
    private $name;
    private $description;
    private $muscle_group;
    private $image;

    public function __construct($id, $name, $description, $muscle_group, $image) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->muscle_group = $muscle_group;
        $this->image = $image;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getMuscleGroup() {
        return $this->muscle_group;
    }

    public function getImage() {
        return $this->image;
    }
}