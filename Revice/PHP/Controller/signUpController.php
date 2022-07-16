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
    //echo $input." ";
    $input = trim($input);
    $input = stripcslashes($input);
    return htmlspecialchars($input);
}
if (isset($_POST['Register'])) {
    if ($_POST['Register'] == "Register"){
        $_SESSION['lang'] = "en";
    }
    else{
        if ($_POST['Register'] == "Înregistrare")
            $_SESSION['lang'] = "ro";
    }
    $username = $email = $password = $retypePassword = "";
    $userNameErr = $emailErr = $passwordErr = $retypePasswordErr = "";
    $dbUser = new DBUser();
    $serviceUser = new ServiceUser();
    if (empty($_POST["Username"])) {
        if ($_SESSION['lang'] == "en") {
            $userNameErr = "Username is required";
        } else if ($_SESSION['lang'] == "ro") {
            $userNameErr = "Username-ul este obligatoriu";
        }
    } else {
        $username = cleanInput($_POST["Username"]);
        $userFromDatabase = $dbUser->getUserByUsernameEmail($username, "");
        $usernameCheck = $serviceUser->checkIfUsernameIsTaken($userFromDatabase);
        if ($usernameCheck == 1) {
            if ($_SESSION['lang'] == "en") {
                $userNameErr = "The username is already taken!";
            } else if ($_SESSION['lang'] == "ro") {
                $userNameErr = "Username-ul este deja luat!";
            }
        }
    }
    if (empty($_POST["Email"])) {
        if ($_SESSION['lang'] == "en") {
            $emailErr = "Email is required!";
        } else if ($_SESSION['lang'] == "ro") {
            $emailErr = "Email-ul este obligatoriu!";
        }
    } else {
        $email = cleanInput($_POST["Email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($_SESSION['lang'] == "en") {
                $emailErr = "Invalid email format";
            } else if ($_SESSION['lang'] == "ro") {
                $emailErr = "Formatul email-ului este incorect!";
            }
        }
        $userFromDatabase = $dbUser->getUserByUsernameEmail("", $email);
        $usernameCheck = $serviceUser->checkIfUsernameIsTaken($userFromDatabase);
        if ($usernameCheck == 1) {
            if ($_SESSION['lang'] == "en") {
                $emailErr = "Email is already taken!";
            } else if ($_SESSION['lang'] == "ro") {
                $emailErr = "Email-ul este deja luat!";
            }
        }
    }
    if (empty($_POST["Password"])) {
        if ($_SESSION['lang'] == "en") {
            $passwordErr = "Password is required";
        } else if ($_SESSION['lang'] == "ro") {
            $passwordErr = "Parola este obligatorie";
        }
    } else {
        $password = cleanInput($_POST["Password"]);
        $uppercasePass = preg_match('@[A-Z]@', $password);
        $lowercasePass = preg_match('@[a-z]@', $password);
        $numberPass = preg_match('@[0-9]@', $password);
        if (!$uppercasePass || !$lowercasePass || !$numberPass || strlen($password) < 8 || strlen($password) > 40) {
            if ($_SESSION['lang'] == "en") {
                $passwordErr = "Password should be at least 8 in length and should include at least one upper case letter and one number";
            } else if ($_SESSION['lang'] == "ro") {
                $passwordErr = "Parola trebuie să aibă cel puțin 8 caractere și trebuie să includă cel puțin o literă mare și un număr";
            }
        }
    }
    if (empty($_POST["RetypePassword"])) {
        if ($_SESSION['lang'] == "en") {
            $retypePasswordErr = "You must put your password again";
        } else if ($_SESSION['lang'] == "ro") {
            $retypePasswordErr = "Trebuie să pui parola din nou";
        }
    } else {
        $retypePassword = cleanInput($_POST["RetypePassword"]);
        if (strcmp($password, $retypePassword) != 0) {
            if ($_SESSION['lang'] == "en") {
                $retypePasswordErr = "Passwords are not the same!";
            } else if ($_SESSION['lang'] == "ro") {
                $retypePasswordErr = "Parolele nu sunt aceleasi!";
            }
        }
    }
//am trecut prin toate filtrele, inseram in baza de date
//verificam daca avem erori
    if ($userNameErr == "" && $emailErr == "" && $passwordErr == "" && $retypePasswordErr == "") {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $dbUser->insertNewUser($username, $email, $hashPassword);
        if ($_SESSION['lang'] == "en") {
            echo json_encode(['success' => "You have created your account!"]);
        } else if ($_SESSION['lang'] == "ro") {
            echo json_encode(['error'=>"Ați creat contul dvs"]);
        }
    }
    else{
        if (!empty($userNameErr))
            echo json_encode(['error' => $userNameErr]);
        else if (!empty($emailErr))
            echo json_encode(['error' => $emailErr]);
        else if (!empty($passwordErr))
            echo json_encode(['error' => $passwordErr]);
        else if (!empty($retypePasswordErr))
            echo json_encode(['error' => $retypePasswordErr]);
        else
            echo json_encode(['error'=>"Error from the server!"]);
    }
}