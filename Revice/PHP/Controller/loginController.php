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
if (isset($_POST['Login'])) {
    if ($_POST['Login'] == "Login"){
        $_SESSION['lang'] = "en";
    }
    else{
        if ($_POST['Login'] == "Logare")
            $_SESSION['lang'] = "ro";
    }
    $userNameEmail = $password = "";
    $userNameEmailErr = $passwordErr = $connectFailed = "";
    if (empty($_POST["UsernameEmail"])) {
        if ($_SESSION['lang'] == "en")
            $userNameEmailErr = "Your email/username must not be empty";
        else if ($_SESSION['lang'] == "ro"){
            $userNameEmailErr = "Email-ul/username-ul nu trebuie sa fie gol";
        }
    }
    else {
        $userNameEmail = cleanInput($_POST["UsernameEmail"]);
    }
    if (empty($_POST["Password"])) {
        if ($_SESSION['lang'] == "en")
            $passwordErr = "Password must not be empty";
        else if ($_SESSION['lang'] == "ro"){
            $passwordErr = "Parola nu trebuie să fie goală";
        }
    } else {
        $password = cleanInput($_POST["Password"]);
    }
    if (!empty($_POST["UsernameEmail"]) && !empty($_POST["Password"])) {
        $dbUser = new DBUser();
        $serviceUser = new ServiceUser();
        $getUserFromDB = $dbUser->getUserByUsernameEmail($userNameEmail, $userNameEmail);

        $returnFunction = $serviceUser->checkIfUserIntroducedGoodDataController($getUserFromDB, $password);

        $connectSucces = "";
        if ($returnFunction == 0) {
            //it is logged, redirect to index.php
            //header("Location: index.php");
            if ($_SESSION['lang'] == "en")
                $connectSucces = "You are connected!";
            else if ($_SESSION['lang'] == "ro"){
                $connectSucces = "Sunteți conectat!";
            }
        } else if ($returnFunction == 1) {
            if ($_SESSION['lang'] == "en")
                $connectFailed = "This username/email does not exist!";
            else if ($_SESSION['lang'] == "ro"){
                $connectFailed = "Username-ul/Email-ul nu există!";
            }
        } else if ($returnFunction == 2) {
            if ($_SESSION['lang'] == "en")
                $connectFailed = "The password is incorrect!";
            else if ($_SESSION['lang'] == "ro"){
                $connectFailed = "Parola este incorectă!";
            }
        }
        if ($connectSucces == "")
            echo json_encode(['error'=>$connectFailed]);
        else
            echo json_encode(['success'=>$connectSucces]);
    }
    else{
        if (!empty($userNameEmailErr))
            echo json_encode(['error'=>$userNameEmailErr]);
        else if (!empty($passwordErr))
            echo json_encode(['error'=>$passwordErr]);
    }
}
