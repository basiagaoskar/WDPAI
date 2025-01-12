<?php

require_once 'Repository.php';

class WorkoutRepository extends Repository {
    public function getAllBasicWorkouts() {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM basic_workouts
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getWorkoutByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM basic_workouts WHERE LOWER(title) LIKE :search OR LOWER(description) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllExercises() {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM exercises ORDER BY muscle_group
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
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
    
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}