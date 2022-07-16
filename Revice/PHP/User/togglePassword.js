const togglePassword = document.querySelector('#togglePassword');
password = document.querySelector('#id_password');
togglePassword.addEventListener('click', function () {
    if (password.type === "password") {
        password.type = "text";
        togglePassword.classList.replace("fa-eye-slash", "fa-eye");
    } else {
        password.type = "password";
        togglePassword.classList.replace("fa-eye", "fa-eye-slash");
    }
});