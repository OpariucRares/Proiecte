<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/DBConnection.php");

if (!isset($_SESSION)) {
    session_start();
}
class DBUser
{
    public function getUserByUsernameEmail($username, $email){
        $dbHandler = new DBConnection();
        $select = $dbHandler->conn->prepare('SELECT account_id, username, password, status from user where username = ? OR email = ?');
        $select->execute([$username, $email]);
        if ($select->rowCount() != 0) return $select->fetch();
        return null;
    }
    public function insertNewUser($username, $email, $password){
        $dbHandler = new DBConnection();
        $insert = $dbHandler->conn->prepare('Insert into user(username, email, password) values(?, ?, ?)');
        $insert->execute([$username, $email, $password]);
//        $insert = $dbHandler->conn->prepare('Insert into user(username, email, password, status) values(?, ?, ?, ?)');
//        $insert->execute([$username, $email, $password, 'admin']);
    }
    public function getPasswordBySessionIdUsername($account_id, $username){
        $dbHandler = new DBConnection();
        $select = $dbHandler->conn->prepare('select password from user where username = ? AND account_id = ?');
        $select->execute([$username, $account_id]);
        if ($select->rowCount() != 0) return $select->fetch();
        return null;
    }
    public function updatePassword($newPassword, $username, $accountId){
        $dbHandler = new DBConnection();
        $update = $dbHandler->conn->prepare('UPDATE user SET password = ? where username = ? and account_id = ?');
        $update->execute([$newPassword, $username, $accountId]);
    }
    public function deleteUserTokenFromDatabase($userId){
        $dbHandler = new DBConnection();
        $delete = $dbHandler->conn->prepare('DELETE FROM user_token where user_id = ?');
        $delete->execute([$userId]);
    }
    public function insertUserTokenInDatabase($userId, $token, $serial, $date){
        $dbHandler = new DBConnection();
        $insert = $dbHandler->conn->prepare('Insert into user_token(user_id, token, serial, date) values(?, ?, ?, ?)');
        $insert->execute([$userId, $token, $serial, $date]);
    }
    public function findUserTokenBySelector($selector){
        $dbHandler = new DBConnection();
        $select = $dbHandler->conn->prepare('select token from user_token where serial = ? and date >= now()');
        $select->execute([$selector]);
        if($select->rowCount() > 0){
            return $select->fetch();
        }
        return null;
    }
    public function finUserByTokenDatabase($token){
        $dbHandler = new DBConnection();
        $select = $dbHandler->conn->prepare('select account_id, username from user 
                                JOIN user_token ON user_id = account_id
                                where serial = ? and date >= now()');
        $select->execute([$token]);
        return $select->fetch();
    }
}