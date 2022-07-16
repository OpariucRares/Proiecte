<?php
//echo "hello";
require_once($_SERVER['DOCUMENT_ROOT'] . "/PHP/DBConnection.php");
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user_type'])){
    header("Location:".$_SERVER['DOCUMENT_ROOT']."/index.php");
}
else if ($_SESSION['user_type'] != 'admin'){
    header("Location:".$_SERVER['DOCUMENT_ROOT']."/index.php");
}
else {
    $dbHandler = new DBConnection();
    $select = $dbHandler->conn->prepare('select * from products order by rating desc limit 10');
    $select->execute();
    $web_url = "http://localhost/RSS/rss.xml";

    $str = "<?xml version='1.0' ?>";
    $str .= "<rss version='2.0'>";
    $str .= "<channel>";
    $str .= "<title>Cele mai bune produse din Romania </title>";
    $str .= "<description>Astazi va vom arata top 3 cele mai bune produse din Romania in functie de rating-ul lor. Informatiile sunt luate de pe Emag, Altex si ITGalaxy</description>";
    $str .= "<language>en-US</language>";
    $str .= "<link>$web_url</link>";


    while ($row = $select->fetch()) {
        $str .= "<item>";
        $str .= "<title>" . htmlspecialchars($row['name']) . "</title>";
        $descriere = "Pret: " . $row['price'] . " lei.\nRating: " . $row['rating'] . " stele.\nMagazin: " . $row['store'] . ".\nTip: " . $row['type'];
        $str .= "<description>" . $descriere . "</description>";
        $str .= "<link>" . htmlspecialchars($row['link']) . "</link>";
        $str .= "</item>";
    }

    $str .= "</channel>";
    $str .= "</rss>";
    file_put_contents("rss.xml", $str);
    echo "Done";
}
