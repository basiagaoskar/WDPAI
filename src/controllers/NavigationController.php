<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/WorkoutRepository.php';

class NavigationController extends AppController {
    private $userRepository;
    private $currentUser;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->currentUser = $this->getCurrentUser();
    }

    private function getCurrentUser() {
        return $this->userRepository->getUser($_SESSION['user_email']);
    }

    public function workouts() {
        $workoutRepository = new WorkoutRepository();
        $workouts = $workoutRepository->getAllWorkouts();
        return $this->render('main/workouts', ['currentUser' => $this->currentUser, 'workouts' => $workouts]);
    }

    public function profile() {
        $profileImage = $this->userRepository->getProfileImage($_SESSION['user_email']);
        $bio = $this->userRepository->getBio($_SESSION['user_email']);
        return $this->render('main/profile', ['currentUser' => $this->currentUser, 'profileImage' => $profileImage, 'bio' => $bio]);
    }

    public function createWorkout() {
        $workoutRepository = new WorkoutRepository();
        $exercises = $workoutRepository->getAllExercises();
        return $this->render('main/createWorkout', ['currentUser' => $this->currentUser, 'exercises' => $exercises]);
    }
}