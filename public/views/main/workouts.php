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
                    <form>
                        <input placeholder="search">
                    </form>
                </div>
                <div class="add-workout">
                    <i class="fas fa-plus"></i>
                    add 
                </div>
            </header>
            <section class="workouts">
                <div id="workout-1">
                    <img src="/public/img/workouts/push-pull-legs.jpg">
                    <div>
                        <h2>Push-Pull-Legs</h2>
                        <p>
                            Push: Training pushing muscles (chest, shoulders, triceps).<br>
                            Pull: Training pulling muscles (back, biceps).<br>
                            Legs: Training legs (quads, hamstrings, glutes, calves).
                        </p>
                        <div class="social-section">
                            <i class="fas fa-heart"> 600</i>
                            <div class="learn-more">
                                <a href=""> 
                                    Learn more
                                    <i class="fa-solid fa-arrow-right "></i>
                                </a>                                        
                            </div>
                        </div>
                    </div>
                </div>
                <div id="workout-2">
                    <img src="/public/img/workouts/upper-lower.webp">
                    <div>
                        <h2>Upper/Lower</h2>
                        <p>
                            Upper Body: Training the upper body (chest, back, shoulders, arms).<br>
                            Lower Body: Training the lower body (legs, glutes).
                        </p>
                        <div class="social-section">
                            <i class="fas fa-heart"> 600</i>
                            <div class="learn-more">
                                <a href=""> 
                                    Learn more
                                    <i class="fa-solid fa-arrow-right "></i>
                                </a>                                        
                            </div>
                        </div>
                    </div>
                </div>
                <div id="workout-3">
                    <img src="/public/img/workouts/fbw.jpg">
                    <div>
                        <h2>Full Body</h2>
                        <p>
                            A workout that targets all major muscle groups in one session.
                        </p>
                        <div class="social-section">
                            <i class="fas fa-heart"> 600</i>
                            <div class="learn-more">
                                <a href=""> 
                                    Learn more
                                    <i class="fa-solid fa-arrow-right "></i>
                                </a>                                        
                            </div>
                        </div>
                    </div>
                </div>
                <div id="workout-4">
                    <img src="/public/img/workouts/bro-split.jpg">
                    <div>
                        <h2>Bro Split</h2>
                        <p>
                            Each muscle group is trained once per week (e.g., chest on Monday, back on Tuesday, legs on Wednesday, etc.).
                        </p>
                        <div class="social-section">
                            <i class="fas fa-heart"> 600</i>
                            <div class="learn-more">
                                <a href=""> 
                                    Learn more
                                    <i class="fa-solid fa-arrow-right "></i>
                                </a>                                        
                            </div>
                        </div>
                    </div>
                </div>
                <div id="workout-5">
                    <img src="/public/img/workouts/calisthenics.avif">
                    <div>
                        <h2>Calisthenics</h2>
                        <p>
                            Focuses on exercises using your own body weight as resistance like pull-ups, push-ups, dips.
                            <p>
                        <div class="social-section">
                            <i class="fas fa-heart"> 600</i>
                            <div class="learn-more">
                                <a href=""> 
                                    Learn more
                                    <i class="fa-solid fa-arrow-right "></i>
                                </a>                                        
                            </div>
                        </div>
                    </div>
                </div>
                <div id="workout-6">
                    <img src="/public/img/workouts/functional_training.jpg">
                    <div>
                        <h2>Functional Training</h2>
                        <p>
                            Focuses on movements that mimic daily activities or sports, emphasizing overall fitness.
                        </p>
                        <div class="social-section">
                            <i class="fas fa-heart"> 600</i>
                            <div class="learn-more">
                                <a href=""> 
                                    Learn more
                                    <i class="fa-solid fa-arrow-right "></i>
                                </a>                                        
                            </div>
                        </div>
                    </div>
                </div>
                <div id="workout-7">
                    <img src="/public/img/workouts/powerlifting.jpg">
                    <div>
                        <h2>Powerlifting</h2>
                        <p>
                            Focuses on building maximal strength through three core compound movements: squat, bench press and deadlift, emphasizing power and technique.
                        </p>
                        <div class="social-section">
                            <i class="fas fa-heart"> 600</i>
                            <div class="learn-more">
                                <a href=""> 
                                    Learn more
                                    <i class="fa-solid fa-arrow-right "></i>
                                </a>                                        
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>