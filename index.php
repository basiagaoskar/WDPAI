<?php

require_once 'Routing.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$timeout = 300; 
$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

$protectedRoutes = ['workouts', 'main', 'adminPanel'];

if (in_array($path, $protectedRoutes)) {
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

Routing::get('login', 'DefaultController');
Routing::get('logout', 'SecurityController');
Routing::get('registration', 'DefaultController');
Routing::get('workouts', 'DefaultController');
Routing::get('home', 'DefaultController');
Routing::get('adminPanel', 'AdminController');

Routing::post('registration', 'SecurityController');
Routing::post('login', 'SecurityController');
Routing::post('changeRole', 'AdminController');
Routing::post('deleteUser', 'AdminController');

Routing::run($path);