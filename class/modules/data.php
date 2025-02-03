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

    public function getFoodWithDetails() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    food.*, 
                    shop.name AS shopname, 
                    food_type.name AS foodtype 
                FROM food 
                    JOIN shop ON food.shop_id = shop.id 
                    JOIN food_type ON food.type_id = food_type.id
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getWhere($conditions, $params = []) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $this->table_name WHERE {$conditions}");
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $this->handleError($e);
        }
    }

    public function getCartWithFoodDetails($user_id) {
        try {
            $sql = "SELECT cart.*, food.name AS food_name, food.food_img AS food_img 
                    FROM cart 
                    JOIN food ON food.id = cart.food_id 
                    WHERE cart.uses_id = :user_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function delete($conditions, $params = []) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table_name WHERE {$conditions}");
            $stmt->execute($params);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getTotalQty($userId) {
        try {
            $stmt = $this->pdo->prepare("SELECT SUM(qty) FROM $this->table_name WHERE uses_id = :userId");
            $stmt->bindParam(":userId", $userId);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
