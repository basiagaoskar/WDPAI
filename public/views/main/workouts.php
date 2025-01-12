<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
    <link rel="icon" type="image/x-icon" href="/public/public/img/icon.ico">
    <title>Workouts</title>
    <link rel="stylesheet" type="text/css" href="/public/css/main/nav-styles.css">
    <link rel="stylesheet" type="text/css" href="/public/css/main/workouts-styles.css">
    <script type="text/javascript" src="/public/js/search.js" defer></script>
</head>
<body>
    <div class="base-container">
        <nav>
            <div class="logo-and-text">
                <h1>ZIUTKI GYM</h1>
                <img src="/public/img/logo.png" alt="Logo">
            </div>
            <ul>
                <li>
                    <i class="fa-solid fa-user"></i>
                    <a href="profile" class="nav-button">Profile</a>
                </li>
                <li>
                    <i class="fa-solid fa-dumbbell"></i>
                    <a href="workouts" class="nav-button">Workouts</a>
                </li>
                <li>
                    <i class="fa-solid fa-user-group"></i>
                    <a href="users" class="nav-button">Users</a>
                </li>
                <li>
                    <i class="fa-solid fa-bell"></i>
                    <a href="notifications" class="nav-button">Notifications</a>
                </li>
                <li>
                    <i class="fa-solid fa-gear"></i>
                    <a href="setting" class="nav-button">Setting</a>
                </li>
                <?php if ($currentUser->getRole() === 'admin'): ?>
                <li>
                    <i class="fa-solid fa-user-shield"></i>
                    <a href="/adminPanel" class="nav-button">Admin Panel</a>
                </li>
                <?php endif; ?>
                <li>
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <form action="/logout" method="POST" style="display:inline;">
                        <button type="submit" class="nav-button">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
        <main>
            <header>
                <div class="search-bar">
                    <input placeholder="search workout" id="search-workout">
                </div>
                    <a href="createWorkout" class="add-workout"> 
                        <i class="fas fa-plus"></i>add workout
                    </a>
            </header>
            <section class="workouts" id="workout-container">
                <?php foreach ($workouts as $workout): ?>
                    <div id="workout-<?= $workout->getId(); ?>">
                        <img src="public/img/workouts/<?= $workout->getImage(); ?>">
                        <div>
                            <h2><?= $workout->getTitle(); ?></h2>
                            <p><?= $workout->getDescription(); ?></p>
                            <div class="social-section">
                                <div class="learn-more">
                                    <a href=""> 
                                        Learn more
                                        <i class="fa-solid fa-arrow-right "></i>
                                    </a>                                        
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </main>
    </div>
</body>
</html>

<template id="workout-template">
    <div id="">
        <img src="">
        <div>
            <h2>title</h2>
            <p>description</p>
            <div class="social-section">
                <div class="learn-more">
                    <a href=""> 
                        Learn more
                       <i class="fa-solid fa-arrow-right "></i>
                    </a>                                        
                </div>
            </div>
        </div>
    </div>
</template>