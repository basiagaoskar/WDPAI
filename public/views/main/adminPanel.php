<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
    <link rel="icon" type="image/x-icon" href="/img/icon.ico">
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="/public/css/main/adminPanel-styles.css">
    <link rel="stylesheet" type="text/css" href="/public/css/main/nav-styles.css">
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
            <header>
                <h1>Manage Users</h1>
            </header>
            
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

            <section class="users">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Role</th>
                        <th>Action</th>
                        <th>Delete</th>
                    </tr>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user->getId(); ?></td>
                            <td><?= $user->getEmail(); ?></td>
                            <td><?= $user->getName(); ?></td>
                            <td><?= $user->getSurname(); ?></td>
                            <td><?= $user->getRole(); ?></td>
                            <td>
                                <form action="changeRole" method="POST">
                                    <input type="hidden" name="email" value="<?= $user->getEmail(); ?>">
                                    <select name="role">
                                        <option value="user" <?= $user->getRole() === 'user' ? 'selected' : '' ?>>User</option>
                                        <option value="admin" <?= $user->getRole() === 'admin' ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                    <button type="submit">Change Role</button>
                                </form>
                            </td>
                            <td>    
                                <form action="deleteUser" method="POST" style="display:inline;">
                                    <input type="hidden" name="email" value="<?= $user->getEmail(); ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </section>
        </main>
    </div>
</body>
</html>