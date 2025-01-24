<?php

require '../db.php';
session_start();
header("location: $base");

if ($_GET['type'] === "checkout") {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE uses_id = ?");
    $stmt->execute([$id]);
    $cart = $stmt->fetchAll();
    
    try {
        $grouped = [];
        foreach ($cart as $datas) {
            $grouped[$datas['shop_id']][] = $datas;
        }
        
        foreach ($grouped as $shop_id => $items) {
            $stmt = $pdo->prepare("INSERT INTO orders (date, delivery_status, user_id, shop_id) VALUES (NOW(), 0, ?, ?)");
            $stmt->execute([$_SESSION['user_login'], $shop_id]);
            $orders = $pdo->lastInsertId();
    
            foreach ($items as $data) {
                $stmt = $pdo->prepare("INSERT INTO order_detail (id, food_id, price, discount, qty) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([
                    $orders,
                    $data['food_id'],
                    $data['price'],
                    $data['discount'],
                    $data['qty']
                ]);
                $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ?");
                $stmt->execute([$data['id']]);
            }
        }
    
        $_SESSION['success'] = "สั่งอาหารแล้ว Delivery มาส่งนะครับ 😁";
    } catch (PDOException $e) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
    

} elseif ($_GET['type'] === "delete") {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = "ลบออกจากตะกล้าแล้ว";
} elseif ($_GET['type'] === "get") {
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM food WHERE id = ?");
        $stmt->execute([$id]);
        $food = $stmt->fetch();
        $name = $food['name'];

        $stmt = $pdo->prepare("SELECT * FROM cart WHERE food_id = ? AND uses_id = ?");
        $stmt->execute([$food['id'], $_SESSION['user_login']]);
        $ItemEx = $stmt->fetch();

        if ($ItemEx) {
            $stmt = $pdo->prepare("UPDATE cart SET qty = ? WHERE uses_id = ? AND food_id = ?");
            $stmt -> execute([$ItemEx['qty'] + $qty, $_SESSION['user_login'], $food['id']]);
            $_SESSION['success'] = "เพิ่ม $name แล้ว จำนวน $qty ชิ้น";
        } else {
            $stmt = $pdo->prepare("INSERT INTO cart (name, price, qty, discount, uses_id, food_id, shop_id) VALUES (?,?,?,?,?,?,?)");
            $stmt -> execute([$food['name'], $food['price'], $qty, $food['discount'], $_SESSION['user_login'], $id,  $food['shop_id']]);
            $_SESSION['success'] = "เพิ่ม $name แล้ว จำนวน $qty ชิ้น";
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = $e -> getMessage();
    }
}

?>