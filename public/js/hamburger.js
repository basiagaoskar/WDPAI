document.addEventListener("DOMContentLoaded", function() {
    const hamburgerBtn = document.getElementById("hamburger-btn");
    const sidebar = document.querySelector("nav");

    hamburgerBtn.addEventListener("click", function() {
        sidebar.classList.toggle("active");
    });
});