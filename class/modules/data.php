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
    }

    public function update($req, $wh, $params = []) {
        $stmt = $this->pdo->prepare("UPDATE $this->table_name SET $req WHERE $wh");
        $stmt->execute($params);
    }

    public function delete($wh, $param) {
        $stmt = $this->pdo->prepare("DELETE FROM $this->table_name WHERE $cons");
        $stmt->execute($param);
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
