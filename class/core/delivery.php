<?php

require '../db.php';
session_start();
header("location: $base");

if ($_GET['type'] === "apply") {
    $id = $_POST['id']; 

    try {
        $stmt = $pdo->prepare("UPDATE orders SET delivery_id = ? WHERE id = ?");
        $stmt ->execute([$_SESSION['user_login'], $id]);
        $_SESSION['success'] = "รับเรียบร้อย ✨" ;
    } catch (PDOException $e) {
        $_SESSION['error'] = $e ->getMessage();
    }
} elseif ($_GET['type'] === "apply_payment") {
    $id = $_POST['id']; 
    try {
        $stmt = $pdo->prepare("UPDATE orders SET delivery_status = ? WHERE id = ?");
        $stmt ->execute([1, $id]);
        $_SESSION['success'] = "ยืนยันเรียบร้อย ✨" ;
    } catch (PDOException $e) {
        $_SESSION['error'] = $e ->getMessage();
    }
}
?>