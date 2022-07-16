$(function () {
    $('#login_form').on('submit', function (event) {
        event.preventDefault();
        //let language = $("#Language").val();
        let username = $("#Username").val();
        let email = $("#Email").val();
        let password = $("#id_password").val();
        let retypePassword = $("#id_retype_password").val();
        let register = $("#Register").val();

        //alert($("#Language").val());
        // console.log(username);
        // console.log(email);
        // console.log(password);
        // console.log(retypePassword);
        // console.log(register);
        $.ajax({
            type: 'POST',
            url: "http://localhost:63342/PHP/Controller/signUpController.php",
            data: {
                Username:username,
                Email: email,
                Password: password,
                RetypePassword : retypePassword,
                Register : register
            }
        }).then(function (res) {
            console.log(res);
            let data = JSON.parse(res);
            if (data.error) {
                $(".form-message").html(data.error);
            } else if (data.success) {
                $(".form-message").html(data.success);
                location.href = "login.php";
            }
        });
    });
});