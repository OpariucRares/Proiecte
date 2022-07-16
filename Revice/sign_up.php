<?php
declare (strict_types=1);
require_once './PHP/config.php';
/**
 * @var object $pdo
 */
function cleanInput($input)
{
    $input = trim($input);
    $input = stripcslashes($input);
    return htmlspecialchars($input);
}

try {


    $username = $email = $password = $retypePassword = "";
    $userNameErr = $emailErr = $passwordErr = $retypePasswordErr = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["Username"]))
            $userNameErr = "Username is required";
        else {
            $userName = cleanInput($_POST["Username"]);
            //we want the username to start with a letter
            if (!preg_match("/^[a-zA-Z][a-zA-Z-' ]*/", $userName))
                $userNameErr = "The Username does not start with at least a letter!";
            $selectUsername = $pdo->prepare('SELECT username from user where username = ?');
            if ($selectUsername->execute([$userName]) && $selectUsername->rowCount()) {
                $userNameErr = "The username is already taken!";
            }

        }
        if (empty($_POST["Email"])) {
            $emailErr = "Email is required";
        } else {
            $email = cleanInput($_POST["Email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
            $selectEmail = $pdo->prepare('SELECT email from user where email = ?');
            if ($selectEmail->execute([$email]) && $selectEmail->rowCount()) {
                $emailErr = "Email is already taken";
            }
        }
        if (empty($_POST["Password"])) {
            $passwordErr = "Password is required";
        } else {
            $password = cleanInput($_POST["Password"]);
            $uppercasePass = preg_match('@[A-Z]@', $password);
            $lowercasePass = preg_match('@[a-z]@', $password);
            $numberPass    = preg_match('@[0-9]@', $password);
            if(!$uppercasePass || !$lowercasePass || !$numberPass || strlen($password) < 8 || strlen($password) > 40) {
                $passwordErr = "Password should be at least 8 and maximum 40 characters in length and should include at least one upper case letter and one number";
            }
        }
        if (empty($_POST["RetypePassword"])) {
            $retypePasswordErr = "You must put your password again";
        } else {
            $retypePassword = cleanInput($_POST["RetypePassword"]);
            if (strcmp($password, $retypePassword) != 0) {
                $retypePasswordErr = "Passwords are not the same!";
            }
        }
        //am trecut prin toate filtrele, inseram in baza de date
        //verificam daca avem erori
        if (!empty($userName) && !empty($email) && !empty($password) && !empty($retypePassword)) {
            $insert = $pdo->prepare('Insert into user(username, email, password) values(?, ?, ?)');
            $insert->execute([$userName, $email, $password]);
        }
    }

}
catch (PDOException $e) {
    echo "Eroare: " . $e->getMessage();
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
</head>
<body>
<section>
    <div class = "image-box">
        <div class = "image-content">

        </div>
    </div>
    <div class = "content-box">
        <div class = "forum-box">
            <div>
                <a class = "button-home" style = "color:#bcbdc0" href = "index.html"> Home </a>
            </div>
            <div class = "login-text">
                <h2>Sign up</h2>
            </div>
            <form method="post">
                <div class = "input-box">

                    <i class="fa fa-user"></i>
                    <span>

            Username
            </span>

                    <input type = "text" name = "Username" placeholder="Username">
                    <span><?php echo $userNameErr;?></span>
                </div>

                <div class = "input-box">
                    <i class="fa fa-envelope"></i>
                    <label>Email</label>
                    <input type = "email" name = "Email" placeholder="Email">
                    <span><?php echo $emailErr;?></span>
                </div>

                <div class = "input-box">
                    <i class="fa fa-lock-open"></i>
                    <span>Password
            </span>
                    <i class="fa fa-eye-slash" id="togglePassword" ></i>
                    <input type = "password" name = "Password" placeholder="Password" id = "id_password">

                    <span><?php echo $passwordErr;?></span>
                </div>

                <div class = "input-box">
                    <i class="fa fa-lock"></i>
                    <span>Retype Password</span>
                    <input type = "password" name = "RetypePassword" placeholder="Retype Password">
                    <span><?php echo $retypePasswordErr;?></span>
                </div>
                <div class = "remember">
                    <label><input type = "checkbox" name = "Remember">Remember me</label>
                </div>
                <div class = "input-box">
                    <!-- <label><input type = "submit" value = "Register" name = "Register"  onclick="window.location='index.html'"  ></label> -->
                    <label><input type = "submit" value = "Register" name = "Register" ></label>
                </div>
                <div class = "input-box">
                    <p> You already have an account? <a href= "login.php"> Sign in</a> </p>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    password = document.querySelector('#id_password');

    togglePassword.addEventListener('click', function (e) {
        if (password.type === "password"){
            password.type = "text";
            togglePassword.classList.replace("fa-eye-slash", "fa-eye");
        }
        else{
            password.type = "password";
            togglePassword.classList.replace("fa-eye", "fa-eye-slash");
        }
    });
</script>
</body>
</html>