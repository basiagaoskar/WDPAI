<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
    <link rel="icon" type="image/x-icon" href="/public/img/icon.ico">
    <link rel="stylesheet" href="/public/css/errors-styles.css">
    <title>Error</title>
</head>
<body>
    <div class="container">
        <h1 class="error-code"><?php echo $number?></h1>
        <img src="/public/img/error.png" alt="Error <?php echo $number?>">
        <p class="message"><?php echo $message?></p>
        <a href="/home" class="home-link"><i class="fas fa-home"></i> Go Back Home</a>
    </div>
</body>
</html>