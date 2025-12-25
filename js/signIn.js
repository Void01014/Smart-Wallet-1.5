let form = document.querySelector("#form");
let email = document.querySelector("#email");
let password = document.querySelector("#password");

const email_RGX = /^[A-Za-z0-9]+@gmail.com$/;
const password_RGX = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.!@#$%^&*]).{8,}$/

form.addEventListener('submit', (e) => {
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
