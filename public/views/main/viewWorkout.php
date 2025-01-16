<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
    <link rel="icon" type="image/x-icon" href="/public/img/icon.ico">
    <title>Workout Details</title>
    <link rel="stylesheet" type="text/css" href="/public/css/main/nav-styles.css">
    <link rel="stylesheet" type="text/css" href="/public/css/main/viewWorkout-styles.css">
    <base href="http://localhost:8080/">
    <script src="/public/js/hamburger.js" defer></script>
</head>
<body>
    <div class="base-container">
        <div class="hamburger-menu">
            <button id="hamburger-btn">
            <i class="fa-solid fa-bars"></i>
            </button>
        </div>
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
                    <i class="fa-solid fa-gear"></i>
                    <a href="settings" class="nav-button">Settings</a>
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
            <section class="viewWorkout-section">
                <h1><?= $workout->getTitle() ?></h1>
                <h2>Exercises</h2>
                <section class="exercises-section">
                    <div class="scrollable-exercises">
                        <div class="exercises-container">
                            <?php foreach ($exercises as $exercise): ?>
                                <div class="exercise-card">
                                    <img src="/public/img/exercises/<?= $exercise->getImage() ?>" alt="Exercise Image">
                                    <h3><?= $exercise->getName() ?></h3>
                                    <p><?= $exercise->getDescription() ?></p>
                                    <p><strong>Muscle Group:</strong> <?= $exercise->getMuscleGroup() ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
                <?php if ($currentUser->getId() === $workout->getUserId() || $currentUser->getRole() === 'admin'):?>
                    <form action="deleteWorkout" method="POST">
                        <input type="hidden" name="workout_id" value="<?= $workout->getId() ?>">
                        <button type="submit">Delete Workout</button>
                    </form>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>