<?php

require_once 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/' );
$path = parse_url($path, PHP_URL_PATH);

Routing::get('login', 'DefaultController');
Routing::get('workouts', 'DefaultController');
Routing::get('home', 'DefaultController');
Routing::run($path);