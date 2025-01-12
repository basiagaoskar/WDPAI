<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/WorkoutRepository.php';

class WorkoutsController extends AppController {

    public function search() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $workoutRepository = new WorkoutRepository();
            echo json_encode($workoutRepository->getWorkoutByTitle($decoded['search']));
        }
    }

    public function addWorkout() {
        if ($this->isPost()) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $image = $_FILES['image']['name'];
            $target = "public/img/workouts/".basename($image);
            $userId = $_POST['userId'];

            move_uploaded_file($_FILES['image']['tmp_name'], $target);

            $workoutRepository = new WorkoutRepository();
            $workoutId = $workoutRepository->addWorkout($title, $description, $userId, $image);

            $exercises = $_POST['exercises'];
            foreach ($exercises as $exerciseId) {
                $workoutRepository->addExerciseToWorkout($workoutId, $exerciseId);
            }

            header("Location: /workouts");
        }
    }
}