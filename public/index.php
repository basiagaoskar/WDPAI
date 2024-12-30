<?php

require_once 'Routing.php';

session_start();

$timeout = 300; 
$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

$protectedRoutes = ['workouts', ''];

if (in_array($path, $protectedRoutes)) {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
        session_unset();
        session_destroy();
        header('Location: /login?message=SessionExpired');
        exit;
    }

    $_SESSION['last_activity'] = time();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: /login?message=LoginRequired');
        exit;
    }
}

Routing::get('login', 'DefaultController');
Routing::post('login', 'SecurityController');
Routing::get('logout', 'SecurityController');
Routing::get('registration', 'DefaultController');
Routing::post('registration', 'SecurityController');
Routing::get('workouts', 'DefaultController');
Routing::get('home', 'DefaultController');

Routing::run($path);