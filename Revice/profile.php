<?php
require_once './PHP/User/ServiceUser.php';
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/User/DBUser.php");
/** @var TYPE_NAME $lang */
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/changeLanguage.php");


if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['s_username']) && !isset($_SESSION['account_id'])) {
    header("Location: index.php");
}
if (isset($_POST['Logout'])) {
    ServiceUser::logout();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="CSS/profile/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <title>Profile</title>
    <meta name="description" content="Put your description here.">
    <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<section>
    <div class="image-box">
        <div class="profileBar">
            <h1><?php echo $lang['profile_welcome'] ?> <?php echo $_SESSION['s_username'] ?>!</h1>
        </div>
        <div class="content-box">
            <div class="forum-box">
                <div>
                    <form method="post" style="position: ">
                        <a class="button-home" style="color:#bcbdc0;"
                           href="index.php"> <?php echo $lang['profile_home'] ?> </a>
                        <input class="button-home" type="submit" name="Logout"
                               value="<?php echo $lang['profile_logout'] ?>"/>
                    </form>
                </div>
                <div class="login-text">
                    <h2><?php echo $lang['profile_change_pass'] ?></h2>
                </div>
                <h3 class="form-message" style="padding-top:  10px; padding-bottom:5px "></h3>
                <h3 class="gunoi" style="display: none"></h3>
                <form action="changePasswordForm.php" method="post" class = "form-submit">
                    <div class="input-box">

                        <i class="fa fa-lock-open"></i>
                        <span>
                          <?php echo $lang['profile_old_pass'] ?>
                        </span>

                        <label>
                            <input type="password" name="OldPassword" id = "id_password"
                                   placeholder="<?php echo $lang['profile_insert_old_pass'] ?>">
                        </label>
                    </div>
                    <br>
                    <div class="input-box">
                        <i class="fa fa-unlock"></i>
                        <span><?php echo $lang['profile_new_pass'] ?></span>
                        <label for="id_new_password"></label><input type="password" name="NewPassword"
                                                                    placeholder="<?php echo $lang['profile_insert_new_pass'] ?>"
                                                                    id="id_new_password">
                        <div id="messageForPass" style="display: none">
                            <p id="letter"><?php echo $lang['profile_letter'] ?></p>
                            <p id="capital"><?php echo $lang['profile_capital'] ?></p>
                            <p id="number"><?php echo $lang['profile_number'] ?></p>
                            <p id="length"><?php echo $lang['profile_length'] ?></b></p>
                        </div>
                    </div>
                    <div class="input-box"><br>
                        <i class="fa fa-lock"></i>
                        <span><?php echo $lang['profile_retype_pass'] ?></span>
                        <label for="id_retype_password"></label><input type="password" name="RetypeNewPassword"
                                                                       placeholder="<?php echo $lang['profile_insert_retype_pass'] ?>"
                                                                       id="id_retype_password">
                        <span id="messageForRetypePass" style="display: none"> </span>
                    </div>
                    <br>
                    <div class="input-box">
                        <label><input type="submit" value="<?php echo $lang['profile_change_password'] ?>" name="ChangePassword" id = "change_password"
                        </label>
                    </div>
                    <br>
                    <div class="input-box">
                    </div>
            </div>
        </div>
    </div>
</section>
<script>
    let inputPassword = document.getElementById("id_new_password");
    //cand apas pe celula, apare textul
    inputPassword.onfocus = function () {
        document.getElementById("messageForPass").style.display = "block";
    }
    //cand iese, dispare
    inputPassword.onblur = function () {
        document.getElementById("messageForPass").style.display = "none";
    }
    //cand incepe sa tasteze, apar mesajele
    inputPassword.onkeyup = function () {
        //litere mici
        let lowerCaseLetters = /[a-z]/g;
        if (inputPassword.value.match(lowerCaseLetters)) {
            document.getElementById("letter").style.display = "none";

        } else {
            document.getElementById("letter").style.display = "block";
        }
        //litere mari
        let upperCaseLetters = /[A-Z]/g;
        if (inputPassword.value.match(upperCaseLetters)) {
            document.getElementById("capital").style.display = "none";
        } else {
            document.getElementById("capital").style.display = "block";
        }
        //cifre
        let numbers = /[0-9]/g;
        if (inputPassword.value.match(numbers)) {
            document.getElementById("number").style.display = "none";
        } else {
            document.getElementById("number").style.display = "block";
        }
        //lungimea sa fie minima 8 si maxim 40
        if (inputPassword.value.length >= 8) {
            document.getElementById("length").style.display = "none";
        } else {
            document.getElementById("length").style.display = "block";
        }
    }
</script>
<script >
    let sess_username = '<?php echo $_SESSION['s_username']?>';
    let sess_id = '<?php echo $_SESSION['account_id']?>';
    $(document).ready(function () {
        $(".form-submit").submit(function (event) {
            event.preventDefault();
            let oldPassword = $("#id_password").val();
            let newPassword = $("#id_new_password").val();
            let retypeNewPassword = $("#id_retype_password").val();
            let changePassword = $("#change_password").val();
            $(".gunoi").load("changePasswordForm.php", {
                Username: sess_username,
                AccountId : sess_id,
                OldPassword : oldPassword,
                NewPassword : newPassword,
                RetypePassword: retypeNewPassword,
                ChangePassword : changePassword,
            });
             $.ajax({
                 type: 'POST',
                 url: "http://localhost/PHP/Controller/changePasswordController.php",
                 cache: false,
                 data: {
                     Username: sess_username,
                     AccountId : sess_id,
                     OldPassword : oldPassword,
                     NewPassword : newPassword,
                     RetypePassword: retypeNewPassword,
                     ChangePassword : changePassword,
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

</script>
</body>
</html>