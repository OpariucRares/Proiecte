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
if (isset($_POST['ChangePassword'])) {
    $dbUser = new DBUser();
    $serviceUser = new ServiceUser();
    $oldPassword = $newPassword = $retypePassword  = "";
    if (!empty($_POST["OldPassword"]) && !empty($_POST["NewPassword"]) && !empty($_POST["RetypePassword"])) {
        $oldPassword = cleanInput($_POST["OldPassword"]);
        $newPassword = cleanInput($_POST["NewPassword"]);
        $retypePassword = cleanInput($_POST["RetypePassword"]);
        $userFromDatabase = $dbUser->getPasswordBySessionIdUsername($_POST['AccountId'], $_POST['Username']);
        $passwordCheck = $serviceUser->checkIfPasswordMatches($userFromDatabase, $oldPassword);
        $uppercasePass = preg_match('@[A-Z]@', $newPassword);
        $lowercasePass = preg_match('@[a-z]@', $newPassword);
        $numberPass = preg_match('@[0-9]@', $newPassword);
        if ($uppercasePass && $lowercasePass && $numberPass && strlen($newPassword) >= 8) {
            if ($passwordCheck == 0){
                if (strcmp($newPassword, $retypePassword) == 0){
                    $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $dbUser->updatePassword($hashPassword, $_POST['Username'], $_POST['AccountId']);
                    echo "Changed";
                }
                else echo "Pass no match";
            }
            else echo "Pass not exist";
        }
        else echo "PassNewNOTGOOd";
    }
    else{
        echo "error";
    }
}