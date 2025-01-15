<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
    <link rel="icon" type="image/x-icon" href="/public/public/img/icon.ico">
    <title>Create Workout</title>
    <link rel="stylesheet" type="text/css" href="/public/css/main/nav-styles.css">
    <link rel="stylesheet" type="text/css" href="/public/css/main/createWorkout-styles.css">
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
            <section class="create-workout">
                <header>
                    <h1>Create Workout</h1>
                </header>
                <form action="/addWorkout" method="POST" enctype="multipart/form-data">
                    <label for="title" class="main-label">Title:</label>
                    <input type="text" id="title" name="title" required placeholder="Enter workout title">
                    
                    <label for="description" class="main-label">Description:</label>
                    <textarea id="description" name="description" required placeholder="Enter description"></textarea>
                    
                    <label for="image" class="main-label">Image:</label>
                    <input type="file" id="image" name="image" required>
                    
                    <label for="exercises" class="main-label">Exercises:</label>
                    <div class="scrollable-exercises">
                        <div class="exercises-container">
                            <?php foreach ($exercises as $exercise): ?>
                                <div class="exercise-block">
                                    <input type="checkbox" id="exercise-<?= $exercise->id ?>" name="exercises[]" value="<?= $exercise->id ?>">
                                    <label for="exercise-<?= $exercise->id ?>">
                                        <img src="public/img/exercises/<?= $exercise->image ?>" alt="<?= $exercise->name ?>">
                                        <h3><?= $exercise->name ?></h3>
                                        <p><strong>Muscle Group:</strong> <?= $exercise->muscle_group ?></p>
                                        <p><strong>Instruction:</strong> <?= $exercise->instruction ?></p>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button type="submit">Add Workout</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>