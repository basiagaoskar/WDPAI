
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/login-styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/img/icon.ico">
    <title>Registration Page</title>
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="logo-and-text">
                <h1>ZIUTKI<br>GYM</h1>
                <img class="logo" src="../img/logo.png" alt="Logo">
            </div>
            <img class="registerPhoto" src="../img/register-photo.png" alt="register-photo">
        </div>

        <div class="right">
            <h2>Register</h2>
            <form action="registration" method="POST">
            <div class="input-container">
                <input name="name" type="text" placeholder="👤 Name" autocomplete="on" required>
                <input name="surname" type="text" placeholder="👤 Surname" autocomplete="on" required>
                <input name="email" type="email" placeholder="✉️ Email" autocomplete="on" required>
                <input name="password" id="password" type="password" placeholder="🔒 Password" autocomplete="off" required>
                
                <div class="password-requirements">
                    <ul>
                        <li class="requirement" id="length">At least 8 characters</li>
                        <li class="requirement" id="uppercase">At least one uppercase letter</li>
                        <li class="requirement" id="number">At least one number</li>
                        <li class="requirement" id="special">At least one special character (e.g. @, #, $, etc.)</li>
                    </ul>
                </div>
                <input name="confirm-password" type="password" id="confirm-password" placeholder="🔒 Confirm Password" autocomplete="off" required>
            </div>
            <div class="messages">
                    <?php 
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
                </div>
            <button class="registerButton" id="registerButton" type="submit" disabled>Register</button>
            <a href="login" class="login-link">Already have an account? Login</a>
        </form>
        </div>
    </div>
    <script type="text/javascript" src="/js/PasswordValidator.js"></script>
</body>
</html>