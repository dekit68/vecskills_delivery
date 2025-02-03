<?php

require '../db.php';
session_start();
header("location: $base");

if ($_GET['type'] === "checkout") {

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