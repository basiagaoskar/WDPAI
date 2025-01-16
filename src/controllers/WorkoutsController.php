<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/WorkoutRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';


class WorkoutsController extends AppController {

    public function search() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $workoutRepository = new WorkoutRepository();
            $workouts = $workoutRepository->getWorkoutByTitle($decoded['search']);


            $response = array_map(function($workout) {
                return [
                    'id' => $workout->getId(),
                    'title' => $workout->getTitle(),
                    'description' => $workout->getDescription(),
                    'user_id' => $workout->getUserId(),
                    'image' => $workout->getImage()
                ];
            }, $workouts);

            echo json_encode($response);
        }
    }

    public function addWorkout() {
        if ($this->isPost()) {
            $userId = $_SESSION['user_id'];
            $workoutRepository = new WorkoutRepository();
            $userWorkouts = $workoutRepository->getUserWorkouts($userId);

            if (count($userWorkouts) >= 3) {
                header("Location: /createWorkout?error=You can only create up to 3 workouts.");
                exit();
            }
            $title = $_POST['title'];
            $description = $_POST['description'];
            $image = $_FILES['image']['name'];
            $target = "public/img/workouts/".basename($image);

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

    public function viewWorkout($id) {
        $workoutRepository = new WorkoutRepository();
        $exercises = $workoutRepository->getExercisesByWorkoutId($id);
        $workout = $workoutRepository->getWrokoutById($id);

        if (!is_numeric($id) || $id <= 0 || !$exercises || !$workout) {
            header("Location: /workouts");
            exit();
        }
        $userRepository = new UserRepository();
        $currentUser = $userRepository->getUser($_SESSION['user_email']);
        
        if ($workout->getUserId()) {
            $visibility = $userRepository->getProfileVisibility($workout->getUserId());

            if ($visibility !== 'public' && $currentUser->getId() !== $workout->getUserId() && $currentUser->getRole() !== 'admin') {
                header("Location: /workouts");
                exit();
            }
        }
        return $this->render('main/viewWorkout', ['currentUser' => $currentUser, 'exercises' => $exercises, 'workout' => $workout]);
    }

    public function deleteWorkout() {
        if ($this->isPost()) {
            $workoutId = $_POST['workout_id'];
            $userId = $_SESSION['user_id'];
    
            $workoutRepository = new WorkoutRepository();
            $workout = $workoutRepository->getWorkoutById($workoutId);
            
            $userRepository = new UserRepository();
            $currentUser = $userRepository->getUser($_SESSION['user_email']);

            if ($workout->getUserId() === $userId || $currentUser->getRole() === 'admin') {
                if ($workoutRepository->deleteWorkout($workoutId)) {
                    header('Location: /workouts?success=Workout deleted successfully');
                    exit();
                } else {
                    header('Location: /workouts?error=Failed to delete workout');
                    exit();
                }
            } else {
                header('Location: /workouts?error=Unauthorized');
                exit();
            }
        }
        header('Location: /workouts?error=Invalid request');
        exit();
    }
}