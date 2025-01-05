<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
    <link rel="icon" type="image/x-icon" href="../img/icon.ico">
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="/css/workouts-styles.css">
</head>
<body>
    <div class="base-container">
        <nav>
            <div class="logo-and-text">
                <h1>ZIUTKI GYM</h1>
                <img src="/img/logo.png" alt="Logo">
            </div>
            <ul>
                <li>
                    <i class="fa-solid fa-dumbbell"></i>
                    <a href="workouts" class="button">Workouts</a>
                </li>
                <li>
                    <i class="fa-solid fa-user-group"></i>
                    <a href="#" class="button">Users</a>
                </li>
                <li>
                    <i class="fa-solid fa-bell"></i>
                    <a href="#" class="button">Notifications</a>
                </li>
                <li>
                    <i class="fa-solid fa-gear"></i>
                    <a href="#" class="button">Setting</a>
                </li>
                <?php if ($currentUser->getRole() === 'admin'): ?>
                <li>
                    <i class="fa-solid fa-user-shield"></i>
                    <a href="/adminPanel" class="button">Admin Panel</a>
                </li>
                <?php endif; ?>
                <li>
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <form action="/logout" method="POST" style="display:inline;">
                        <button type="submit" class="button">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
        <main>
            <header>
            <h1>Manage Users</h1>
                <div class="search-bar">
                    <form>
                        <input placeholder="search for a user">
                    </form>
                </div>
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