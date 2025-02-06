<?php 
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "foods";
    public $pdo;

    public function getConnect() {
        $this->pdo = null;
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4;", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection Error: " . $exception->getMessage();
        }
        return $this->pdo;
    }
}
?>