<?php
declare (strict_types=1);

//const DB_HOST = '127.0.0.1';
//const DB_SERVER = 'localhost';
//const DB_USERNAME = 'root';
//const DB_PASSWORD = '';
//const DB_NAME = 'revicedatabase';
//$DSN = "mysql:host=DB_Hos;dbname=$db;charset=$charset";

//datele de conectare la serverul de baze de date MySQL/MariaDB
$host = '';
$db = 'revicedatabase';
$user = 'root';
$pass = ''; //atenție: parola e specificată „în clar”!
$charset = 'utf8';
//stabilirea numelui sursei de date: DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
//opțiuni vizând maniera de conectare
$opt = [
//erorile sunt raportate ca excepții
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//rezultatele vor fi disponibile într-un tablou asociativ
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//conexiunea e persistentă
    PDO::ATTR_PERSISTENT => true
];

try {
    $pdo = new PDO ($dsn, $user, $pass, $opt); // instanțiem un obiect PDO
}
catch (PDOException $e) {
    echo "Eroare: " . $e->getMessage();
}
