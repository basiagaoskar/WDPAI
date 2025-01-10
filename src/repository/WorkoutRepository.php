<?php

require_once 'Repository.php';

class WorkoutRepository extends Repository {
    public function getAllWorkouts() {
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
}