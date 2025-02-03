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
            return "Error: " . $e->getMessage();
        }
    }

    public function getWhere($conditions) {
        try {
            $sql = "SELECT * FROM $this->table_name WHERE {$conditions}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function insert($data) {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $sql = "INSERT INTO $this->table_name ({$columns}) VALUES ({$values})";
            $stmt = $this->pdo->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->execute();
            return "Record inserted successfully!";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function update($data, $conditions) {
        try {
            $set = "";
            foreach ($data as $key => $value) {
                $set .= "$key = :$key, ";
            }
            $set = rtrim($set, ", ");

            $sql = "UPDATE $this->table_name SET {$set} WHERE {$conditions}";
            $stmt = $this->pdo->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return "Record updated successfully!";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function delete($conditions) {
        try {
            $sql = "DELETE FROM $this->table_name WHERE {$conditions}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return "Record deleted successfully!";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
