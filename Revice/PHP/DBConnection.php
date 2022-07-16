<?php
class DBConnection
{
    private string $host = '';
    private string $db = 'revicedatabase';
    private string $user = 'root';
    private string $pass = '';
    private string $charset = 'utf8';
    //opțiuni vizând maniera de conectare
    private array $opt = [
        //erorile sunt raportate ca excepții
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //rezultatele vor fi disponibile într-un tablou asociativ
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        //conexiunea e persistentă
        PDO::ATTR_PERSISTENT => true
    ];
    public ?PDO $conn = null;

    function __construct()
    {
        if ($this->conn == null)
            $this->conn = $this->connectDB();
    }

    function connectDB(): ?PDO
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        try {
            return new PDO ($dsn, $this->user, $this->pass, $this->opt);
        } catch (PDOException $e) {
            echo "Eroare: " . $e->getMessage();
        }
        return null;
    }
}
