<?php 
class Data {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function get($req) {
        $stmt = $this->pdo->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get1($req) {
        $stmt = $this->pdo->prepare($req);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function get2($req) {
        $stmt = $this->pdo->prepare($req);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function add($table_name, $req , $vl, $params = []) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO $table_name ($req) VALUES ($vl)");
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    public function update($table_name, $req, $wh, $params = []) {
        var_dump($params);
        try {
            $stmt = $this->pdo->prepare("UPDATE $table_name SET $req WHERE $wh");
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    public function delete($table_name, $wh, $param) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM $table_name WHERE $wh");
            $stmt->execute([$param]);
            return true;
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    public function checkout($userId) {
        $cart = $this->get("SELECT * FROM cart WHERE user_id = $userId");
        if (empty($cart)) {
            return $_SESSION['error'] = "ไม่มีของในตะกล้าเว้ยยยย";
        }
        $grouped = [];
        foreach ($cart as $datas) {
            $grouped[$datas['shop_id']][] = $datas;
        }
        foreach ($grouped as $shop_id => $items) {
            var_dump($shop_id);
            $stmt = $this->pdo->prepare("INSERT INTO orders (time, delivery_status, user_id, shop_id) VALUES (NOW(), 0, ?, ?)");
            $stmt->execute([$userId, $shop_id]);
            $orders = $this->pdo->lastInsertId();

            foreach ($items as $data) {
                $this->add('order_detail', 'id, food_id, price, discount, qty', '?,?,?,?,?', [$orders,$data['food_id'],$data['price'],$data['discount'],$data['qty']]);
                $this->delete('cart', 'id = ?', $data['id']);
            }
        }
        try {
            $_SESSION['success'] = "ลงแล้ว 55555555555555";
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }
}
?>