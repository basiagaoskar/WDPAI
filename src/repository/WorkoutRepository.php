<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Workout.php';

class WorkoutRepository extends Repository {
    public function getAllBasicWorkouts() {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM basic_workouts
        ');
        $stmt->execute();

        $workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function($workout) {
            return new Workout(
                $workout['id'],
                $workout['title'],
                $workout['description'],
                null,
                $workout['image']
            );
        }, $workouts);
    }

    public function getWorkoutByTitle(string $searchString) {
        $searchString = '%' . strtolower($searchString) . '%';
    
        $stmt = $this->database->connect()->prepare('
            SELECT id, title, description, NULL as user_id, image, 1 as sort_order FROM basic_workouts 
            WHERE LOWER(title) LIKE :search OR LOWER(description) LIKE :search
            UNION
            SELECT id, title, description, user_id, image, 2 as sort_order FROM workouts 
            WHERE (LOWER(title) LIKE :search OR LOWER(description) LIKE :search) AND user_id = :userId
            ORDER BY sort_order, id
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->bindParam(':userId',  $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
    
        $workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function($workout) {
            return new Workout(
                $workout['id'],
                $workout['title'],
                $workout['description'],
                $workout['user_id'],
                $workout['image']
            );
        }, $workouts);
    }

    public function getAllExercises() {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM exercises ORDER BY muscle_group
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getWorkoutTitle($id) {
        $stmt = $this->database->connect()->prepare('
            SELECT title FROM workouts WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getExercisesByWorkoutId($workoutId) {
        $stmt = $this->database->connect()->prepare('
            SELECT e.id, e.name, e.muscle_group, e.instruction, e.image 
            FROM exercises e
            JOIN workout_exercises we ON e.id = we.exercise_id
            WHERE we.workout_id = :workoutId
        ');
        $stmt->bindParam(':workoutId', $workoutId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addWorkout($title, $description, $userId, $image) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO workouts (title, description, user_id, image) 
            VALUES (:title, :description, :userId, :image) 
            RETURNING id
        ');
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function addExerciseToWorkout($workoutId, $exerciseId) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO workout_exercises (workout_id, exercise_id) VALUES (:workoutId, :exerciseId)
        ');
        $stmt->bindParam(':workoutId', $workoutId, PDO::PARAM_INT);
        $stmt->bindParam(':exerciseId', $exerciseId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getUserWorkouts($userId) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM workouts WHERE user_id = :user_id
        ');
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function($workout) {
            return new Workout(
                $workout['id'],
                $workout['title'],
                $workout['description'],
                $workout['user_id'],
                $workout['image']
            );
        }, $workouts);
    }
}