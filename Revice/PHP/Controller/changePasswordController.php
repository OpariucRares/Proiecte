<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/User/ServiceUser.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/User/DBUser.php");
header("Access-Control-Allow-Origin: *");
/** @var TYPE_NAME $lang */
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/changeLanguage.php");
if (!isset($_SESSION)) {
    session_start();
}
function cleanInput($input): string
{
    $input = trim($input);
    $input = stripcslashes($input);
    return htmlspecialchars($input);
}
if (isset($_POST['ChangePassword']) && !empty($_POST['AccountId']) && !empty($_POST['Username'])) {
    $dbUser = new DBUser();
    $serviceUser = new ServiceUser();
    $oldPassword = $newPassword = $retypePassword = $messageUser = "";
    $oldPassError = $newPassError = $retypePassErr = "";
    if ($_POST['ChangePassword'] == "Login"){
        $_SESSION['lang'] = "en";
    }
    else{
        if ($_POST['ChangePassword'] == "Schimbați parola")
            $_SESSION['lang'] = "ro";
    }
    if (empty($_POST["OldPassword"])) {
        if ($_SESSION['lang'] == "en") {
            $oldPassError = "Old password is required";
        } else if ($_SESSION['lang'] == "ro") {
            $oldPassError = "Parola veche este obligatorie";
        }
    } else {
        $oldPassword = cleanInput($_POST["OldPassword"]);
        $userFromDatabase = $dbUser->getPasswordBySessionIdUsername($_POST['AccountId'], $_POST['Username']);
        $passwordCheck = $serviceUser->checkIfPasswordMatches($userFromDatabase, $oldPassword);
        if ($passwordCheck == 1) {
            if ($_SESSION['lang'] == "en") {
                $oldPassError = "The user does not exist!";
            } else if ($_SESSION['lang'] == "ro") {
                $oldPassError = "User-ul nu există!";
            }
        } else if ($passwordCheck == 2) {
            if ($_SESSION['lang'] == "en") {
                $oldPassError = "The old password does not match!";
            } else if ($_SESSION['lang'] == "ro") {
                $oldPassError = "Parola veche nu se potrivește!";
            }
        }
    }
    if (empty($_POST["NewPassword"])) {
        if ($_SESSION['lang'] == "en") {
            $newPassError = "The new password is required!";
        } else if ($_SESSION['lang'] == "ro") {
            $newPassError = "Parola nouă este obligatorie!";
        }
    } else {
        $newPassword = cleanInput($_POST["NewPassword"]);
        $uppercasePass = preg_match('@[A-Z]@', $newPassword);
        $lowercasePass = preg_match('@[a-z]@', $newPassword);
        $numberPass = preg_match('@[0-9]@', $newPassword);
        if (!$uppercasePass || !$lowercasePass || !$numberPass || strlen($newPassword) < 8) {
            if ($_SESSION['lang'] == "en") {
                $newPassError = "Password should be at least 8 in length and should include at least one upper case letter and one number";
            } else if ($_SESSION['lang'] == "ro") {
                $newPassError = "Parola trebuie să aibă cel puțin 8 lungime și să includă cel puțin o literă mare și o cifră!";
            }
        }
    }
    if (empty($_POST["RetypePassword"])) {
        if ($_SESSION['lang'] == "en") {
            $retypePassErr = "You must put your password again";
        } else if ($_SESSION['lang'] == "ro") {
            $retypePassErr = "Trebuie sa pui parola din nou";
        }
    } else {
        $retypePassword = cleanInput($_POST["RetypePassword"]);
        if (strcmp($newPassword, $retypePassword) != 0) {
            if ($_SESSION['lang'] == "en") {
                $retypePassErr = "Passwords are not the same!";
            } else if ($_SESSION['lang'] == "ro") {
                $retypePassErr = "Parolele nu sunt aceleași";
            }
        }
    }
    if ($oldPassError == "" && $newPassError == "" && $retypePassErr == "") {
        if ($_SESSION['lang'] == "en") {
            $messageUser = "Your password is now changed";
        } else if ($_SESSION['lang'] == "ro") {
            $messageUser = "Parola ta este schimbată";
        }
        echo json_encode(["success"=>$messageUser]);
    } else {
        if (!empty($oldPassError)){
            echo json_encode(["error"=>$oldPassError]);
        }
        else if (!empty($newPassError)){
            echo json_encode(["error"=>$newPassError]);
        }
        else if (!empty($retypePassErr)){
            echo json_encode(["error"=>$retypePassErr]);
        }
    }
}
else{
    echo json_encode(["error"=>"Server Problem"]);
}