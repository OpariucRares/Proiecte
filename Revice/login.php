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
try{
    $userNameEmail = $password = "";
    $userNameEmailErr = $passwordErr = $connectFailed = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (empty($_POST["UsernameEmail"]))
            $userNameEmailErr = "Your email/username must not be empty";
        else{
            $userNameEmail = cleanInput($_POST["UsernameEmail"]);
        }
        if (empty($_POST["Password"])){
            $passwordErr = "Password must not be empty";
        }
        else{
            $password = cleanInput($_POST["Password"]);
        }
        if (!empty($_POST["UsernameEmail"]) && !empty($_POST["Password"])){
            $select = $pdo->prepare('SELECT username, email, password from user where ((username = ? OR email = ?) AND password = ?)');
            if ($select->execute([$userNameEmail, $userNameEmail, $password]) && $select->rowCount()){
                $connectFailed = "You are connected";
            }
            else{
                $connectFailed = "Connection failed!";
            }
        }
    }
}
catch (PDOException $e){
    echo "Eroare ". $e->getMessage();
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
                <h2>Login</h2>
            </div>
            <form method="post">
                <div class = "input-box">

                    <i class="fa fa-user"></i>
                    <span>
          
            Username/Email
            </span>

                    <input type = "text" name = "UsernameEmail" placeholder="Insert your email/Username">
                    <span><?php echo $userNameEmailErr;?></span>
                </div>
                <div class = "input-box">
                    <i class="fa fa-lock" ></i>
                    <span>Password</span>
                    <input type = "password" name = "Password" placeholder="Insert your password">
                    <span><?php echo $passwordErr;?></span>
                </div>
                <div class = "remember">
                    <label><input type = "checkbox" name = "RememberMe">Remember me</label>
                </div>
                <div class = "input-box">
                    <label><input type = "submit" value = "Login" name = "Login" <!--onmousedown="window.location='index.html'" --> </label>
                    <span><?php echo $connectFailed;?></span>
                </div>
                <div class = "input-box">
                    <p> Don't have an account? <a href= "sign_up.php"> Sign up</a> </p>
                </div>
            </>
        </div>
    </div>
</section>
</body>
</html>