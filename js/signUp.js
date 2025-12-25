let form = document.querySelector("#form");
let username = document.querySelector("#username");
let email = document.querySelector("#email");
let password = document.querySelector("#password");

const username_RGX = /^([A-Z][a-zA-Z]{1,})( [A-Z][A-Za-z]{1,}){0,2}$/
const email_RGX = /^[A-Za-z0-9]+@gmail.com$/;
const password_RGX = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.!@#$%^&*]).{8,}$/

form.addEventListener('submit', (e) => {
    if (!username_RGX.test(username.value)) {
        Swal.fire({
            icon: "error",
            text: "The name should only contain characters, and shouldn't have more than 3 spaces",
        });
        e.preventDefault();
        return
    }
    if (!email_RGX.test(email.value)) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Please enter a Valid email",
        });
        e.preventDefault();
        return
    }
    if (!password_RGX.test(password.value)) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Please enter a valid password",
        });
        e.preventDefault();
        return
    }
});
