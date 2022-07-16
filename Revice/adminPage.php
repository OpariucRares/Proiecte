<?php
require_once './PHP/User/ServiceUser.php';
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/User/DBUser.php");
/** @var TYPE_NAME $lang */
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/changeLanguage.php");


if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['s_username']) && !isset($_SESSION['account_id']) && !isset($_SESSION['user_type'])) {
    header("Location: index.php");
}
if ($_SESSION['user_type'] != 'admin'){
    header("Location: index.php");
}
if (isset($_POST['Logout'])) {
    ServiceUser::logout();
}
?>
<?php
require_once './PHP/config.php';
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/DBConnection.php");
if(isset($_POST['button1'])) {
    $dbHandler = new DBConnection();
    $var=substr($_POST['button1'], strpos($_POST['button1'], '#')+1);
    $delete = $dbHandler->conn->prepare('DELETE FROM products where id = ?');
    $delete->execute([$var]);
}
if(isset($_POST['button2'])) {
    $dbHandler = new DBConnection();
    $var=substr($_POST['button2'], strpos($_POST['button2'], '#')+1);
    $delete = $dbHandler->conn->prepare('DELETE FROM user where account_id = ?');
    $delete->execute([$var]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/adminPage.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="CSS/profile/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Profile</title>
    <meta name="description" content="Put your description here.">
    <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<section>
    <div class="image-box">
        <div class="profileBar">
            <h1><?php echo $lang['profile_welcome_admin'] ?> <?php echo $_SESSION['s_username'] ?>!</h1>
        </div>
        <div class="content-box">
            <div class="forum-box">
                <div>
                    <form method="post">
                        <a class="button-home" style="color:#bcbdc0;"
                           href="index.php"> <?php echo $lang['profile_home'] ?> </a>
                        <input class="button-home" type="submit" name="Logout"
                               value="<?php echo $lang['profile_logout'] ?>"/>
                    </form>
                    <form method="get">
                        <input class="button-home" type="submit" name="Products"
                               value="Products"/>
                        <input class="button-home" type="submit" name="Users"
                               value="Users"/>
                    </form>
                </div>
                <div class="cards">
                    <div class="new-arrival">
                        <h1><?php if(isset($_GET['Products'])){ echo $lang['productss'];} else { echo $lang['userss'];}?></h1>
                    </div>
                    <?php
                    $dbHandler = new DBConnection();
                    if(isset($_GET['Products'])) {
                        $select = $dbHandler->conn->prepare('select * from products');
                        $select->execute();
                        while ($row = $select->fetch()){
                            echo '<div class="card">';
                            echo '<div class="description">';
                            echo '<h1>' . $row['name']. '</h1>';
                            echo '<p><b>ID:</b><span>' . $row['id']. '</span></p>';
                            echo '</div>';
                            echo '<div class="button-group">';
                            echo '<form method="post">';
                            echo '<input type="submit" class="buy" name="button1" value="Delete Product #'.$row['id'].'"/>';
                            echo '</form>';
                            echo '</div>';
                            echo '<div class="star-icons">';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    else if(isset($_GET['Users']))
                    {
                        $select = $dbHandler->conn->prepare('select * from user where account_id != ?');
                        $select->execute([$_SESSION['account_id']]);
                        while ($row = $select->fetch()){
                            echo '<div class="card">';
                            echo '<div class="description">';
                            echo '<h1>' . $row['username']. '</h1>';
                            echo '<p><b>ID:</b><span>' . $row['account_id']. '</span></p>';
                            echo '</div>';
                            echo '<div class="button-group">';
                            echo '<form method="post">';
                            echo '<input type="submit" class="buy" name="button2" value="Delete User #'.$row['account_id'].'"/>';
                            echo '</form>';
                            echo '</div>';
                            echo '<div class="star-icons">';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>

</section>
</body>
</html>