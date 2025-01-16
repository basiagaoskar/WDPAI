<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
    <link rel="icon" type="image/x-icon" href="/img/icon.ico">
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="/public/css/main/settings-styles.css">
    <link rel="stylesheet" type="text/css" href="/public/css/main/nav-styles.css">
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
            <section class="settings-container">
                <header>
                    <h1>Settings</h1>
                </header>
                
                <div class="settings-section">
                    <h2>Change Password</h2>
                    <form action="/changePassword" method="POST">
                        <div class="form-group">
                            <label for="current-password">Current Password</label>
                            <input type="password" id="current-password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new-password">New Password</label>
                            <input type="password" id="new-password" name="new_password" required>
                        </div>
                        <button type="submit">Change Password</button>
                    </form>
                </div>

                <div class="settings-section">
                    <h2>Change Email</h2>
                    <form action="/changeEmail" method="POST">
                        <div class="form-group">
                            <label for="new-email">New Email Address</label>
                            <input type="text" id="new-email" name="new_email" required>
                        </div>
                        <button type="submit">Change Email</button>
                    </form>
                </div>

                <div class="settings-section">
                    <h2>Delete Account</h2>
                    <form action="/deleteAccount" method="POST">
                        <div class="form-group">
                            <label for="confirm-delete">Type "DELETE" to confirm</label>
                            <input type="text" id="confirm-delete" name="confirm_delete" required>
                        </div>
                        <button type="submit">Delete Account</button>
                    </form>
                </div>

                <div class="settings-section">
                    <h2>Profile Visibility</h2>
                    <form action="/changeVisibility" method="POST">
                        <div class="form-group">
                            <label for="visibility">Choose visibility</label>
                            <select id="visibility" name="visibility">
                                <?php 
                                $userRepository = new UserRepository();
                                $currentVisibility = $userRepository->getProfileVisibility($currentUser->getId()); ?>
                                <option value="public" <?= ($currentVisibility === 'public') ? 'selected' : '' ?>>Public</option>
                                <option value="private" <?= ($currentVisibility === 'private') ? 'selected' : '' ?>>Private</option>
                            </select>
                        </div>
                        <button type="submit">Save Visibility</button>
                    </form>
                </div>
                <?php 
                $success = $_GET['success'] ?? null;
                $error = $_GET['error'] ?? null;
                if (isset($success)): ?>
                    <div class="alert-success">
                        <?= htmlspecialchars($success) ?>
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