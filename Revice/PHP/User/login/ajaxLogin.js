$(document).ready(function () {
    $("form").submit(function (event) {
        event.preventDefault();
        let username = $("#UsernameEmail").val();
        let password = $("#id_password").val();
        let login = $("#Login").val();
        let rememberMe = $("#RememberMe").is(':checked');
        $(".gunoi").load("loginForm.php", {
            UsernameEmail: username,
            Password: password,
            Login: login,
            RememberMe : rememberMe
        });
        $.ajax({
            type: 'POST',
            url: "http://localhost:63342/PHP/Controller/loginController.php",
            cache: false,
            data: {
                UsernameEmail: username,
                Password: password,
                Login: login
            },
        }).then(function (res) {
            console.log(res);
            let data = JSON.parse(res);
            if (data.error) {
                $(".form-message").html(data.error);
            } else if (data.success) {
                $(".form-message").html(data.success);
                location.href = "index.php";
            }
        });
    });
});

