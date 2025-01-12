<?php

require_once 'Routing.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$timeout = 3000; 
$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

$protectedRoutes = ['workouts', 'main', 'profile', 'createWorkout', 'adminPanel', 'viewWorkout', 'users'];

if (in_array($path, $protectedRoutes) || preg_match('/^workouts\/\d+$/', $path)) {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
        session_unset();
        session_destroy();
        header('Location: /login?message=Session Expired');
        exit;
    }

    $_SESSION['last_activity'] = time();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: /login?message=Login Required');
        exit;
    }
}

Routing::get('home', 'DefaultController');
Routing::get('login', 'DefaultController');
Routing::get('registration', 'DefaultController');

Routing::get('logout', 'SecurityController');

Routing::get('profile', 'NavigationController');
Routing::get('workouts', 'NavigationController');
Routing::get('createWorkout', 'NavigationController');
Routing::get('users', 'NavigationController');

Routing::get('viewWorkout', 'WorkoutsController');
Routing::get('adminPanel', 'AdminController');


Routing::post('registration', 'SecurityController');
Routing::post('login', 'SecurityController');

Routing::post('updateProfile', 'ProfileController');

Routing::post('search', 'WorkoutsController');
Routing::post('addWorkout', 'WorkoutsController');

Routing::post('changeRole', 'AdminController');
Routing::post('deleteUser', 'AdminController');

Routing::run($path);