<?php
declare(strict_types = 1);
require_once( $_SERVER['DOCUMENT_ROOT']."/PHP/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/DBConnection.php");
require_once( $_SERVER['DOCUMENT_ROOT']."/PHP/User/DBUser.php");

if (!isset($_SESSION)) {
    session_start();
}
class ServiceUser
{
    public function checkIfPasswordMatches($passwordFromDatabase, $passwordByUser): int
    {
        if ($passwordFromDatabase == null){
            return 1; //"The user does not exist!";
        }
        else{
            $password = $passwordFromDatabase['password'];
            if (!password_verify($passwordByUser, $password)){
                return 2; //"The old password does not match";
            }
        }
        return 0;
    }
    public function checkIfUsernameIsTaken($userFromDatabase): int
    {
        if ($userFromDatabase != null){
            return 1; //"The username/email is already taken!";
        }
        return 0;
    }
    public function checkIfUserIntroducedGoodDataController($userFromDatabase, $passwordByVisitor): int{
        if ($userFromDatabase == null){
            return 1; //"This username/email does not exist!";
        }
        else{
            $password = $userFromDatabase['password'];
            //echo password_verify('rasmuslerdorf', '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq');
            //echo $accountId." ".$username." ".$password." ".$_POST["RememberMe"];
//            echo $password." ";
//            echo password_hash($password, PASSWORD_DEFAULT);
            if (password_verify($passwordByVisitor, $password)) {
                return 0;//redirect to index.php
            } else {
                return 2; //"The password is incorrect!";
            }
        }
    }
    public function checkIfUserIntroducedGoodData($userFromDatabase, $passwordByVisitor, $isCheckedCookie): int
    {
        if ($userFromDatabase == null){
            return 1; //"This username/email does not exist!";
        }
        else{
            $accountId = $userFromDatabase['account_id'];
            $username = $userFromDatabase['username'];
            $password = $userFromDatabase['password'];
            $userType = $userFromDatabase['status'];
            //echo $accountId." ".$username." ".$password." ".$_POST["RememberMe"];
            if (password_verify($passwordByVisitor, $password)) {
                if ($userType == "user") {

                    //correct info
                    //time to check the cookie if it is a user
                    echo "HELLO";
                    if ($isCheckedCookie == "true") {
                        ServiceUser::createCookieSession($accountId, $username, $userType);

                        //echo $_SESSION['s_username']." ".$_SESSION['account_id']." ";
                        //header("Location: index.php");
                        //echo "Hello";
                    } else {
                        if (!isset($_SESSION)) {
                            session_start();
                        }

                        $_SESSION['s_username'] = $username;
                        $_SESSION['account_id'] = $accountId;
                        $_SESSION['user_type'] = $userType;
                        //echo $username." ".$accountId;
//
//                   // header("Location: index.php");
                    }
                }
                else if ($userType == "admin"){
                    //it is an admin, create only the session, even though he checked for rememberMe
                    if (!isset($_SESSION)) {
                        session_start();
                    }

                    $_SESSION['s_username'] = $username;
                    $_SESSION['account_id'] = $accountId;
                    $_SESSION['user_type'] = $userType;
                }
                return 0;//redirect to index.php
            } else {
                return 2; //"The password is incorrect!";
            }
        }
    }
    public static function checkLoginState() : bool
    {
        if (!isset($_SESSION)) {
            //start a new session
            session_start();
        }
        //return self::isUserLoggedIn($pdo);
        if (isset($_COOKIE['rememberMe'])){
            if (self::isTokenValid($_COOKIE['rememberMe'])){
                //the token is not expired, and it matches the data with the database
                //we create the session
                $user = self::findUserByToken($_COOKIE['rememberMe']);
                $_SESSION['account_id'] = $user['account_id'];
                $_SESSION['s_username'] = $user['username'];
                $_SESSION['user_type'] = 'user';
                return true;
            }else{
                //the cookie is expired, it must be deleted
                self::deleteCookie();
                return false;
            }
        }
        else if (isset($_SESSION['s_username'])  && isset($_SESSION['account_id'])){
            return true;
        }
        return false;
    }
    public static function createCookieSession($account_id, $username, $userType){
        $dbUser = new DBUser();
        $dbUser->deleteUserTokenFromDatabase($account_id);

        [$serial, $token, $token_cookie] = self::generateTokens();
        $expiredDate = time() + 60 * 60 * 24 * 30; //one month
        $expire = date('Y-m-d H:i:s', $expiredDate);

        ServiceUser::createCookie($token_cookie);
        ServiceUser::createSession($username, $account_id, $token_cookie, $userType);

        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $dbUser->insertUserTokenInDatabase($account_id, $hashedToken, $serial, $expire);
    }
    public static function createCookie($token_cookie){
        setcookie("rememberMe", $token_cookie, time() + 60 * 60 * 24 * 30);

    }
    public static function createSession($username, $account_id, $token_cookie, $userType){
        if (!isset($_SESSION)){
            session_start();
        }
        $_SESSION['s_username'] = $username;
        $_SESSION['s_token_cookie'] = $token_cookie;
        $_SESSION['user_type'] = $userType;
        $_SESSION['account_id'] = $account_id;
    }
    public static function logout(){
        $dbUser = new DBUser();
        if (!isset($_SESSION)) {
            session_start();
        }
        if (self::isUserLoggedIn()){
            $userId = $_SESSION['account_id'];
            $dbUser->deleteUserTokenFromDatabase($userId);
            unset($_SESSION['s_username'], $_SESSION['account_id'], $_SESSION['user_type']);
            if (!empty($_COOKIE['rememberMe'])) {
                unset($_COOKIE['rememberMe']);
                setcookie('rememberMe', "", time() - 3600);
            }
            session_destroy();
            header("Location: index.php");
        }
    }
    public static function deleteCookie(){
        if (!isset($_SESSION)){
            session_start();
        }
        setcookie('rememberMe', "", time() - 3600);
        session_destroy();
    }
    public static function generateTokens() : ?array{
        try {
            $serial = bin2hex(random_bytes(16));
            $token = bin2hex(random_bytes(32));
            return [$serial, $token, $serial. ':'.$token];
        } catch (Exception $e) {
            echo "Error ". $e->getMessage();
        }
        return null;
    }
    public static function separateTokens($tokenCookie) : ?array{
        $parts = explode(':', $tokenCookie);
        if ($parts && count($parts) == 2){
            return [$parts[0], $parts[1]];
        }
        return null;
    }
    public static function findUserTokenBySelector($selector){
        $dbUser = new DBUser();
        $valueFromFunction = $dbUser->findUserTokenBySelector($selector);
        if ($valueFromFunction == null) return null;
        return $valueFromFunction['token'];
    }
    public static function findUserByToken($token){
        $dbUser = new DBUser();
        $token = self::separateTokens($token);
        if (!$token) {
            return null;
        }
        return $dbUser->finUserByTokenDatabase($token[0]);
    }
    public static function isUserLoggedIn(): bool{
        if (isset($_SESSION['s_username'])) {
            return true;
        }
        $token = filter_input(INPUT_COOKIE, 'rememberMe', FILTER_SANITIZE_STRING);
        if ($token && self::isTokenValid($token)){
            $user = self::findUserByToken($token);
            if ($user){
                return true;
            }
        }
        return false;
    }
    public static function isTokenValid($token) : bool{
        [$selector, $validator] = self::separateTokens($token);
        $tokenFromCookie = self::findUserTokenBySelector($selector);
        if (!$tokenFromCookie) {
            return false;
        }
        return password_verify($validator, $tokenFromCookie);
    }
}