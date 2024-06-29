function myMenuFunction() {
    var i = document.getElementById("navMenu");

    if (i.className === "nav-menu") {
        i.className += " responsive";
    } else {
        i.className = "nav-menu";
    }
}

var loginForm = document.getElementById("login");
var registerForm = document.getElementById("register");

function login() {
    loginForm.style.left = "0";
    registerForm.style.right = "-100%";
    loginForm.style.opacity = 1;
    registerForm.style.opacity = 0;
}

function register() {
    loginForm.style.left = "-100%";
    registerForm.style.right = "0";
    loginForm.style.opacity = 0;
    registerForm.style.opacity = 1;
}

function redirectToHomePage() {
    window.location.href = "/Prototype.html";

}

document.getElementById("signInButton").addEventListener("click", function(event) {
    event.preventDefault();
    redirectToHomePage();
});
