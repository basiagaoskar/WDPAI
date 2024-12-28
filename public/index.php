<?php

require_once 'Routing.php';

session_start();

$timeout = 300; 
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header('Location: /login');
    exit;
}
$_SESSION['last_activity'] = time();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

$protectedRoutes = ['workouts', ''];

if (in_array($path, $protectedRoutes) && !isset($_SESSION['loggedin'])) {
    header('Location: /login');
    exit;
}

Routing::get('login', 'SecurityController');
Routing::post('login', 'SecurityController');
Routing::get('logout', 'SecurityController');
Routing::get('workouts', 'DefaultController');
Routing::get('home', 'DefaultController');

Routing::run($path);