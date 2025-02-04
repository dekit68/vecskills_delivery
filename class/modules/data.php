<?php
class Data {
    private $pdo;
    private $table_name;

    public function __construct($pdo, $table_name) {
        $this->pdo = $pdo;
        $this->table_name = $table_name;
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $this->table_name");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $this->handleError($e);
        }
    }

    public function getWhere($wh, $params = []) {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table_name WHERE $wh");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getforeign($select, $join, $wh, $params = []) {
        $stmt = $this->pdo->prepare("SELECT $select FROM $this->table_name JOIN $join WHERE $wh");
        $stmt->execute($params);
    }

    public function add($req, $wh, $params = []) {
        $stmt = $this->pdo->prepare("INSERT INTO $this->table_name ($req) VALUES ($wh)");
        $stmt->execute($params);
    }

    public function update() {
        
    }

    public function delete($cons, $params = []) {
        $stmt = $this->pdo->prepare("DELETE FROM $this->table_name WHERE $cons");
        $stmt->execute($params);
    }
}
