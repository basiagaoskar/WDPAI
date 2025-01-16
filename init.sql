CREATE TABLE public.users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user'
);

CREATE TABLE public.user_profiles (
    id SERIAL PRIMARY KEY,
    user_id INTEGER UNIQUE REFERENCES public.users(id) ON DELETE CASCADE,
    bio TEXT,
    profile_picture VARCHAR(255),
    visibility VARCHAR(20) DEFAULT 'public'
);

CREATE TABLE public.exercises (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    muscle_group VARCHAR(50),
    instruction TEXT,
    image VARCHAR(255)
);

CREATE TABLE public.basic_workouts (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL
);

CREATE TABLE public.basic_workout_exercises (
    basic_workout_id INTEGER REFERENCES public.basic_workouts(id),
    exercise_id INTEGER REFERENCES public.exercises(id),
    PRIMARY KEY (basic_workout_id, exercise_id)
);

CREATE TABLE public.workouts (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    user_id INTEGER REFERENCES public.users(id) ON DELETE CASCADE,
    image TEXT
);

CREATE TABLE public.workout_exercises (
    workout_id INTEGER REFERENCES public.workouts(id) ON DELETE CASCADE,
    exercise_id INTEGER REFERENCES public.exercises(id) ON DELETE CASCADE,
    PRIMARY KEY (workout_id, exercise_id)
);

CREATE VIEW public.user_profiles_with_details AS
SELECT u.id AS user_id, u.name, u.surname, u.email, p.bio, p.profile_picture, p.visibility
FROM public.users u
LEFT JOIN public.user_profiles p ON u.id = p.user_id;

CREATE VIEW public.workouts_with_exercises AS
SELECT w.id AS workout_id, w.title, w.description, w.user_id, w.image, e.id AS exercise_id, e.name AS exercise_name, e.muscle_group
FROM public.workouts w
JOIN public.workout_exercises we ON w.id = we.workout_id
JOIN public.exercises e ON we.exercise_id = e.id;


CREATE FUNCTION public.create_user_profile() RETURNS trigger
LANGUAGE plpgsql AS $$
BEGIN
    INSERT INTO user_profiles (user_id, bio, profile_picture)
    VALUES (NEW.id, 'No biography available.', 'default.jpg');
    RETURN NEW;
END;
$$;
ALTER FUNCTION public.create_user_profile() OWNER TO "user";

CREATE FUNCTION public.delete_workout_exercises() RETURNS trigger
LANGUAGE plpgsql AS $$
BEGIN
    DELETE FROM workout_exercises WHERE workout_id = OLD.id;
    RETURN OLD;
END;
$$;
ALTER FUNCTION public.delete_workout_exercises() OWNER TO "user";

CREATE TRIGGER after_user_insert
AFTER INSERT ON public.users
FOR EACH ROW EXECUTE FUNCTION public.create_user_profile();

CREATE TRIGGER delete_workout_exercises_trigger
AFTER DELETE ON public.workouts
FOR EACH ROW EXECUTE FUNCTION public.delete_workout_exercises();

INSERT INTO public.users (id, name, surname, email, password, role) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$YJ/bVEJrxkPdUbyMf7tws.y9Fac3VRr8zfGmfpYUk7XxgzRD3ha1a', 'admin');

INSERT INTO public.exercises (id, name, muscle_group, instruction, image) VALUES
(1, 'Bench Press', 'Chest', 'Lie on a bench and press the barbell up, focusing on chest and triceps.', 'bench_press.jpg'),
(2, 'Lateral Raise', 'Shoulders', 'Lift dumbbells out to the sides until they are shoulder height, focusing on your deltoids.', 'lateral_raise.jpg'),
(3, 'Barbell Row', 'Back', 'Bend at the hips and row a barbell or dumbbells towards your waist, engaging your lats.', 'barbell_row.jpg'),
(4, 'Deadlift', 'Back', 'Lift the barbell off the ground while keeping your back straight and engaging your glutes and hamstrings.', 'deadlift.jpg'),
(5, 'Bicep Curl', 'Biceps', 'Use dumbbells to curl the weights up, focusing on contracting the biceps.', 'bicep_curl.jpg'),
(6, 'Triceps Pushdown', 'Triceps', 'Push the bar down until your arms are fully extended, focusing on your triceps.', 'triceps_pushdown.jpg'),
(7, 'Lat Pulldown', 'Back', 'Pull the bar down until your arms are fully extended, focusing on your triceps.', 'lat_pulldown.jpg'),
(8, 'Pull-up', 'Back', 'Grip the bar with your palms facing away, and pull yourself up until your chin clears the bar.', 'pull_up.jpg'),
(9, 'Shoulder Press', 'Shoulders', 'Lift dumbbells or a barbell overhead, focusing on shoulder engagement and core stability.', 'shoulder_press.jpg'),
(10, 'Romanian Deadlift', 'Hamstrings', 'Lower the barbell to just below your knees while keeping your back straight and engaging your hamstrings.', 'romanian_deadlift.jpg'),
(11, 'Dips', 'Chest', 'Lower your body on parallel bars, focusing on your triceps and chest.', 'dips.jpg'),
(12, 'Overhead Triceps Extension', 'Triceps', 'Lift a dumbbell overhead and lower it behind your head, engaging your triceps.', 'overhead_triceps_extension.jpg'),
(13, 'Biceps Preacher Curl', 'Biceps', 'Use a preacher bench to curl the barbell, focusing on your biceps.', 'biceps_preacher_curl.jpg'),
(14, 'Ab Wheel', 'Core', 'Roll out with the ab wheel, keeping your back straight and engaging your core.', 'ab_wheel.jpg'),
(15, 'Hanging Knee Raise', 'Core', 'Hang from a bar and raise your knees towards your chest, engaging your abs.', 'hanging_knee_raise.jpg'),
(16, 'Seated Cable Row', 'Back', 'Pull the cable towards your waist while keeping your back straight, focusing on your lats.', 'seated_cable_row.jpg'),
(17, 'Standing Calf Raise', 'Calves', 'Raise your heels off the ground, focusing on your calves.', 'standing_calf_raise.jpg');

INSERT INTO public.basic_workouts (id, title, description, image) VALUES
(1, 'Push-Pull-Legs', 'Push: Training pushing muscles (chest, shoulders, triceps). Pull: Training pulling muscles (back, biceps). Legs: Training legs (quads, hamstrings, glutes, calves).', 'push-pull-legs.jpg'),
(2, 'Upper/Lower', 'Upper Body: Training the upper body (chest, back, shoulders, arms). Lower Body: Training the lower body (legs, glutes).', 'upper-lower.webp'),
(3, 'Full Body', 'A workout that targets all major muscle groups in one session.', 'fbw.jpg'),
(4, 'Bro Split', 'Each muscle group is trained once per week (e.g., chest on Monday, back on Tuesday, legs on Wednesday, etc.).', 'bro-split.jpg'),
(5, 'Calisthenics', 'Focuses on exercises using your own body weight as resistance like pull-ups, push-ups, dips.', 'calisthenics.avif'),
(6, 'Functional Training', 'Focuses on movements that mimic daily activities or sports, emphasizing overall fitness.', 'functional_training.jpg'),
(7, 'Powerlifting', 'Focuses on building maximal strength through three core compound movements: squat, bench press and deadlift, emphasizing power and technique.', 'powerlifting.jpg');

INSERT INTO public.basic_workout_exercises (basic_workout_id, exercise_id) VALUES
(6, 1), (7, 1), (3, 1), (4, 1), (2, 1), (1, 1), (7, 3), 
(1, 3), (3, 3), (4, 3), (6, 4), (2, 4), (7, 4), (3, 4),
(1, 5), (4, 5), (2, 6), (1, 6), (3, 6), (4, 6), (3, 7), 
(4, 7), (5, 8), (1, 9), (3, 9), (4, 9), (6, 9), (2, 9), 
(2, 10), (6, 10), (1, 10), (4, 10), (5, 11), (4, 11);