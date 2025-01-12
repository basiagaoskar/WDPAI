const search = document.querySelector('input[placeholder="search workout"]');
const workoutContainer = document.querySelector(".workouts");

let timeout;
search.addEventListener("input", function () {
    clearTimeout(timeout); // Reset opóźnienia
    timeout = setTimeout(() => {
        const data = {search: this.value};

        fetch("/search", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (workouts) {
            workoutContainer.innerHTML = "";
            loadWorkouts(workouts);
        });
    }, 100);
});


function loadWorkouts(workouts) {
    workouts.forEach(workout => {
        console.log(workout);
        createProject(workout);
    });
}

function createProject(workout) {
    const template = document.querySelector("#workout-template");

    const clone = template.content.cloneNode(true);
    const div = clone.querySelector("div");
    div.id = workout.id;
    const image = clone.querySelector("img");
    image.src = `/public/img/workouts/${workout.image}`;
    const title = clone.querySelector("h2");
    title.innerHTML = workout.title;
    const description = clone.querySelector("p");
    description.innerHTML = workout.description;

    workoutContainer.appendChild(clone);
}