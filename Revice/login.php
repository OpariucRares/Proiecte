<?php
declare (strict_types=1);
require_once './PHP/User/ServiceUser.php';
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/User/DBUser.php");
/** @var TYPE_NAME $lang */
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/changeLanguage.php");
require($_SERVER['DOCUMENT_ROOT'] . "/PHP/Controller/loginController.php");


if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['s_username']) && isset($_SESSION['account_id'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="CSS/login/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <title>Fullscreen Landing</title>
    <meta name="description" content="Put your description here.">
    <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<section>
    <div class="image-box">
        <div class="image-content">

        </div>
    </div>
    <div class="content-box">
        <div class="forum-box">
            <div>
                <a class="button-home" style="color:#bcbdc0" href="index.php"> <?php echo $lang['home_login']?> </a>
            </div>
            <div class="login-text">
                <h2><?php echo $lang['login_title']?></h2>
            </div>
            <h3 class="form-message" style="padding-top:  10px; padding-bottom:5px "></h3>
            <h3 class="gunoi" style="display: none"></h3>
            <form action = "loginForm.php" method="post">
                <div class="input-box">

                    <i class="fa fa-user"></i>
                    <span>

            <?php echo $lang['login_username_email']?>
            </span>

                    <label>
                        <input id = "UsernameEmail" type="text" name="UsernameEmail" placeholder="<?php echo $lang['login_insert_username_email']?>">
                    </label>
                </div>
                <div class="input-box">
                    <i class="fa fa-lock"></i>
                    <span><?php echo $lang['login_password']?></span>
                    <i class="fa fa-eye-slash" id="togglePassword"></i>
                    <label for="id_password"></label><input type="password" name="Password" placeholder="<?php echo $lang['login_insert_password']?>" id="id_password">
                </div>
                <div class="remember">
                    <label><input type="checkbox" name="RememberMe" id="RememberMe"><?php echo $lang['login_remember_me']?></label>
                </div>
                <div class="input-box">
                    <label><input type="submit" value="<?php echo $lang['login_button']?>" name="Login" id = "Login"</label>
                </div>
                <div class="input-box">
                    <p> <?php echo $lang['login_dont_have']?> <a href="sign_up.php"> <?php echo $lang['login_signup_opt']?></a></p>
                </div>
            </
            >
        </div>
    </div>
</section>
<script type = "text/javascript" src = "/PHP/User/togglePassword.js"></script>
<script type = "text/javascript" src = "/PHP/User/login/ajaxLogin.js"></script>
</body>
</html>