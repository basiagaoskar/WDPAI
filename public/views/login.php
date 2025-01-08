<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="/public/css/login-styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/public/img/icon.ico">
    <title>Login Page</title>
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="logo-and-text">
                <h1>ZIUTKI<br>GYM</h1>
                <img class="logo" src="/public/img/logo.png" alt="Logo">
            </div>
            <img class="benchGuy" src="/public/img/cute-man-barbell.png" alt="bench">
        </div>

        <div class="right">
            <h1>Login</h1>
            <form action="login" method="POST">
                <div class="input-container">
                    <input name="email" type="email" placeholder="✉️ Email" autocomplete="on">
                <div class="password-container"> 
                    <input name="password" id="password" type="password" placeholder="🔒 Password" autocomplete="off">
                    <span  id="togglePassword">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>
                    <a class="forgotPassword" href="/reset-password">Forgot password?</a>
                </div>

                <div class="messages">
                    <?php 
                        if (isset($messages)) {
                            foreach ($messages as $message) {
                                echo $message;
                            }
                        }
                        $message = $_GET['message'] ?? null;
                        if (isset($message)): ?>
                            <?= htmlspecialchars($message) ?>
                    <?php endif; ?>
                </div>

                <button class="loginButton" type="submit">Login</button>
                <a href="registration" class="register-link">Don't have an account? Register here</a>

                <div class="separator">
                    <hr>
                    <span>OR</span>
                    <hr>
                </div>
                
                <div class="socialLogin">
                    <div class="facebook">
                        <button class="facebookLogin"><i class="fa-brands fa-facebook"></i>  Login with Facebook</button>
                    </div>
                    <div class="google">
                        <button class="googleLogin"><i class="fa-brands fa-google"></i>  Login with Google</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="/public/js/PasswordValidator.js"></script>
</body>
</html>