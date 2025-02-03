<?php

require '../db.php';
session_start();
header("location: $base");

if ($_GET['type'] === "delete") {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM shop_type WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = "ลบออกจากตะกล้าแล้ว";
} elseif ($_GET['type'] === "addtype") {
    $name = $_POST['name'];
    try {
        $stmt = $pdo->prepare("INSERT INTO shop_type (name) VALUES (?)");
        $stmt->execute([$name]);
        $_SESSION['success'] = "เพิ่มประเภท $name สำเร็จ";
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }

} elseif ($_GET['type'] === "access") {
    $id = $_POST['id']; 

    try {
        $stmt = $pdo->prepare("SELECT * FROM shop WHERE id = ?");
        $stmt ->execute([$id]);
        $data = $stmt->fetch();
    
        if ($data['approve'] == 0) {
            $stmt = $pdo->prepare("UPDATE shop SET approve = ? WHERE id = ?");
            $stmt ->execute([1,$id]);
            $_SESSION['success'] = "อนุมัติ " . $data['name'] . " เรียบร้อย ✨" ;
        } else {
            $stmt = $pdo->prepare("UPDATE shop SET approve = ? WHERE id = ?");
            $stmt ->execute([0,$id]);
            $_SESSION['success'] = "ยกเลิก " . $data['name'] . " เรียบร้อย 😡" ;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = $e ->getMessage();
    }
} elseif ($_GET['type'] === "deletetype") {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM shop_type WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = "ลบออกจากตะกล้าแล้ว";
} elseif ($_GET['type'] === "get") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    try {   
        $stmt = $pdo->prepare("SELECT * FROM shop WHERE name = ?");
        $stmt -> execute([$name]);
        $data = $stmt->fetch();

        if (!$data) {
            $stmt = $pdo->prepare("INSERT INTO shop (name, type_id, address, phone, user_id) VALUES (?,?,?,?,?)");
            $stmt->execute([$name, $type, $address, $phone, $_SESSION['user_login']]);
            $_SESSION['success'] = "ส่งคำของเปิดร้าน $name เรียบร้อย";
        } else {
            $_SESSION['error'] = "มีชื่อร้าน $name แบ้วว";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}elseif ($_GET['type'] === "update") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $stmt = $pdo->prepare("SELECT * FROM shop WHERE name = ?");
    $stmt -> execute([$name]);
    $Exname = $stmt->fetch();

    try {
        if (!$Exname) {
            $stmt = $pdo->prepare("UPDATE shop SET name = ?, type_id = ?, address = ?, phone = ? WHERE user_id = ?");
            $stmt -> execute([$name, $type, $address, $phone, $_SESSION['user_login']]);
            $_SESSION['success'] = "อัพเดทข้อมูล $name สำเร็จ";
        } else {
            $_SESSION['error'] = "ชื่อซ้ำ";
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }
   
}
?>