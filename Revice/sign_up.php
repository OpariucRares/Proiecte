<?php
declare (strict_types=1);
header("Access-Control-Allow-Origin: *");
require_once './PHP/User/ServiceUser.php';
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/User/DBUser.php");
/** @var TYPE_NAME $lang */
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/changeLanguage.php");
require($_SERVER['DOCUMENT_ROOT'] . "/PHP/Controller/signUpController.php");

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
    <link rel="stylesheet" href="CSS/sign_up/sign_up.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <title>Fullscreen Landing</title>
    <meta name="description" content="Put your description here.">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                <a class="button-home" style="color:#bcbdc0" href="index.php"> <?php echo $lang['home_sign_up'] ?> </a>
            </div>
            <div class="login-text">
                <h2><?php echo $lang['sign_up_title'] ?></h2><br>
            </div>
            <br>
            <h3 class="form-message" style="padding-top:  10px; padding-bottom:5px "></h3>
            <form id = "login_form">
                <div class="input-box">
                    <i class="fa fa-user"></i>
                    <span><?php echo $lang['sign_up_username'] ?></span>
                    <label>

                        <input id="Username" type="text" name="Username"
                               placeholder="<?php echo $lang['sign_up_insert_username'] ?>">
                    </label>

                </div>
                <br>

                <div class="input-box">
                    <i class="fa fa-envelope"></i>
                    <label><?php echo $lang['sign_up_email'] ?></label>
                    <label>
                        <input id="Email" type="text" name="Email"
                               placeholder="<?php echo $lang['sign_up_insert_email'] ?>">
                    </label> <br><br>
                </div>

                <div class="input-box">
                    <i class="fa fa-lock-open"></i>
                    <span><?php echo $lang['sign_up_password'] ?></span>
                    <i class="fa fa-eye-slash" id="togglePassword"></i>
                    <label for="id_password"></label><input type="password" name="Password"
                                                            placeholder="<?php echo $lang['sign_up_insert_password'] ?>"
                                                            id="id_password"/>
                    <div id="messageForPass" style="display: none">
                        <p id="letter"><?php echo $lang['sign_up_letter'] ?></p>
                        <p id="capital"><?php echo $lang['sign_up_capital'] ?></p>
                        <p id="number"><?php echo $lang['sign_up_number'] ?></p>
                        <p id="length"><?php echo $lang['sign_up_length'] ?></p>
                    </div>
                    <br> <br>
                </div>

                <div class="input-box">
                    <i class="fa fa-lock"></i>
                    <span><?php echo $lang['sign_up_retype_password'] ?></span>
                    <label for="id_retype_password"></label><input type="password" name="RetypePassword"
                                                                   placeholder="<?php echo $lang['sign_up_insert_retype_password'] ?>"
                                                                   id="id_retype_password"/>
                    <span id="messageForRetypePass"> </span>

                    <br>
                </div>
                <div class="input-box">
                    <label><input id="Register" type="submit" value="<?php echo $lang['sign_up_register'] ?>"
                                  name="Register"></label>
                </div>
                <div class="input-box">
                    <p><?php echo $lang['sign_up_you_already'] ?> <a
                                href="login.php"> <?php echo $lang['sign_up_sign_in'] ?></a></p>
                </div>

                <br>
            </form>
        </div>
    </div>
</section>
<script type = "text/javascript" src = "/PHP/User/signUp/ajaxSignUp.js"></script>
<script type = "text/javascript" src = "/PHP/User/showErrorMessages.js"></script>
<script type = "text/javascript" src = "/PHP/User/togglePassword.js"></script>
</body>
</html>