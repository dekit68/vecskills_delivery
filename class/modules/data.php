<?php
class Data {
    private $pdo;
    private $table_name;

    public function __construct($pdo, $table_name) {
        $this->pdo = $pdo;
        $this->table_name = $table_name;
    }

    public function get($req) {
        try {
            $stmt = $this->pdo->prepare($req);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $_SESSION['error'] = $e->getMessage();
        }
    }

    public function add($req, $wh, $params = []) {
        $stmt = $this->pdo->prepare("INSERT INTO $this->table_name ($req) VALUES ($wh)");
        $stmt->execute($params);
        try {
            $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ";
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    public function update($req, $wh, $params = []) {
        $stmt = $this->pdo->prepare("UPDATE $this->table_name SET $req WHERE $wh");
        $stmt->execute($params);
        try {
            $_SESSION['success'] = "แก้ไขข้อมูลสำเร็จ";
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    public function delete($wh, $param = []) {
        $stmt = $this->pdo->prepare("DELETE FROM $this->table_name WHERE $wh");
        $stmt->execute($param);
        try {
            $_SESSION['error'] = "ลบข้อมูลสำเร็จ";
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    public function CheckOut($useid) {
        $stmt = $this->pdo->prepare("SELECT * FROM cart WHERE uses_id = ?");
        $stmt->execute([$useid]);
        $cart = $stmt->fetchAll();

        if (empty($cart)) {
            $_SESSION['error'] = "ตะกร้าของคุณว่างเปล่า กรุณาเพิ่มสินค้าก่อนสั่งซื้อ";
            return;
        }

        try {
            $grouped = [];
            foreach ($cart as $datas) {
                $grouped[$datas['shop_id']][] = $datas;
            }
            foreach ($grouped as $shop_id => $items) {
                $stmt = $this->pdo->prepare("INSERT INTO orders (date, delivery_status, user_id, shop_id) VALUES (NOW(), 0, ?, ?)");
                $stmt->execute([$useid, $shop_id]);
                $orders = $this->pdo->lastInsertId();
        
                foreach ($items as $data) {
                    $stmt = $this->pdo->prepare("INSERT INTO order_detail (id, food_id, price, discount, qty) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $orders,
                        $data['food_id'],
                        $data['price'],
                        $data['discount'],
                        $data['qty']
                    ]);
                    $stmt = $this->pdo->prepare("DELETE FROM cart WHERE id = ?");
                    $stmt->execute([$data['id']]);
                }
            }
            $_SESSION['success'] = "สั่งอาหารแล้ว Delivery มาส่งนะครับ 😁";
        } catch (PDOException $e) {
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
    }

    // กำหนดข้อมูลที่ต้องการอัปเดต
    // $req = 'fname = ?, lname = ?'; // ค่าที่จะอัปเดต
    // $wh = 'id = ?'; // เงื่อนไขการค้นหาข้อมูล

    // // กำหนดค่าพารามิเตอร์ที่ต้องใช้ในการแทนที่
    // $params = ['Nut', 'to', 1]; // ค่าที่จะถูกแทนที่ใน ? (fname, lname, id)

    // // เรียกใช้ฟังก์ชัน update
    // $user->update($req, $wh, $params);

    // $user->add(
    //     'name, email, age',     // ชื่อคอลัมน์
    //     '?, ?, ?',              // Placeholder สำหรับค่า
    //     ['นัท', 'nut@example.com', 18]  // ข้อมูลจริง
    // );
}
