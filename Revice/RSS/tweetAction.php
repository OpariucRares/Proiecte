<?php

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
    require_once("rssTOtwitter.php");
    $content = file_get_contents('rss.xml');
    $a = new SimpleXMLElement($content);
    $contor = 1;
    foreach ($a->channel->item as $entry) {
        $title = $entry->title;
        $link = $entry->link;
        $description = $entry->description;
        $input = $contor . "." . trim($title) . "\nLink: " . trim($link) . "\n#redevice";
        $contor++;
        tweet($input);
    }
    $input = "Astazi, " . date("Y/m/d") . ", vom genera in momentul de fata top 10 cele mai bune produse din Romania in functie de rating. Sursele de informatii sunt Emag, Altex si ITGalaxy.";
    tweet($input);
}