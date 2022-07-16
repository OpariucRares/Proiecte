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
    if (!empty($_POST["UsernameEmail"]) && !empty($_POST["Password"])) {
        $dbUser = new DBUser();
        $serviceUser = new ServiceUser();
        $userNameEmail = cleanInput($_POST["UsernameEmail"]);
        $password = cleanInput($_POST["Password"]);
        $isChecked = $_POST["RememberMe"];
        $getUserFromDB = $dbUser->getUserByUsernameEmail($userNameEmail, $userNameEmail);
        $returnFunction = $serviceUser->checkIfUserIntroducedGoodData($getUserFromDB, $password, $isChecked);
    }
}
