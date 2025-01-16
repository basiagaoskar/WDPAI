<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
    <link rel="icon" type="image/x-icon" href="/img/icon.ico">
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="/public/css/main/nav-styles.css">
    <link rel="stylesheet" type="text/css" href="/public/css/main/profile-styles.css">
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
        <section class="profile-section">
                <div class="profile-header">
                    <img src="/public/uploads/<?= $profileImage; ?>" alt="Profile Image" class="profile-image">
                    <h1><?= $currentUser->getName(); ?> <?= $currentUser->getSurname(); ?></h1>
                </div>
                <div class="profile-bio">
                    <h3>Bio</h3>
                    <?php
                        $bio = $bio ?? "No biography available.";
                    ?>
                    <p><?= htmlspecialchars($bio, ENT_QUOTES, 'UTF-8'); ?></p>

                </div>
                <div class="profile-edit">
                    <h3>Edit Profile</h3>
                    <form action="/updateProfile" method="POST" enctype="multipart/form-data">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?= $currentUser->getName(); ?>" required>
                        
                        <label for="surname">Surname:</label>
                        <input type="text" id="surname" name="surname" value="<?= $currentUser->getSurname(); ?>" required>
                        
                        <label for="bio">Bio:</label>
                        <textarea id="bio" name="bio" required><?= $bio; ?></textarea>
                        
                        <label for="profileImage">Profile Image:</label>
                        <input type="file" id="profileImage" name="profileImage">
                        
                        <button type="submit">Update Profile</button>
                    </form>
                </div>
                <?php 
                $message = $_GET['message'] ?? null;
                $error = $_GET['error'] ?? null;
                if (isset($message)): ?>
                    <div class="alert-success">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php elseif (isset($error)): ?>
                    <div class="alert-error">
                        <?= htmlspecialchars($error) ?>
                    </div>
            <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>