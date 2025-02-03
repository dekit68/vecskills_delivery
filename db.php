<?php 
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "!dust@ntdotjsx";
    private $dbname = "mec_foods";
    public $pdo;

    public function __construct() {
        $this->getConnect();
    }

    public function getConnect() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4;", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>