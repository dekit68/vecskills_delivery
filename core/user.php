<?php

require '../db.php';
session_start();
header("location: $base");

if ($_GET['type'] === "update") {
   
} elseif ($_GET['type'] === "change") {
    $password = $_POST['op'];
    $new_password = $_POST['np'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_login']]);
    $user = $stmt->fetch();

    try {
        if ($user['password'] == $password) {
            if ($new_password != $user['password']) {
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt -> execute([$new_password, $_SESSION['user_login']]);
                $_SESSION['success'] = "เปลี่ยนรหัสสำเร็จ";
            } else {
                $_SESSION['error'] = "ตั้งรหัสเดิมไม ?";
            }
        } else {
            $_SESSION['error'] = "รหัสไม่ถูกต้อง";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = $e ->getMessage();
    }
} elseif ($_GET['type'] === "access") {
    $id = $_POST['id']; 

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt ->execute([$id]);
        $data = $stmt->fetch();
    
        if ($data['status'] == 0) {
            $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
            $stmt ->execute([1,$id]);
            $_SESSION['success'] = "อนุมัติ " . $data['fname']. " " .  $data['lname'] . " เรียบร้อย ✨" ;
        } else {
            $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
            $stmt ->execute([0,$id]);
            $_SESSION['success'] = "ยกเลิก " . $data['fname']. " " .  $data['lname'] . " เรียบร้อย 😡" ;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = $e ->getMessage();
    }
} elseif ($_GET['type'] === "delete") {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = "ลบผู้ใช้สำเร็จ";
} elseif ($_GET['type'] === "updatebyadmin") {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    if ($email && $fname && $lname && $address && $phone) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET email = ?, fname = ?, lname = ?, address = ?, phone = ? WHERE id = ?");
            $stmt -> execute([$email, $fname, $lname, $address, $phone, $id]);
            $_SESSION['success'] = "อัพเดทโปรไฟล์ $fname $lname สำเร็จ";
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }
} elseif ($_GET['type'] === "review") {
    $food = $_POST['id'];
    $message = $_POST['message'];
    $star = $_POST['star'];
    try {   
        $stmt = $pdo->prepare("INSERT INTO review (comment, star, user_id, food_id) VALUES (?,?,?,?)");
        $stmt->execute([$message, $star, $_SESSION['user_login'], $food]);
        $_SESSION['success'] = "แสดงความคิดเห็นแล้ว $message เป็นข้อความที่ขยะมาก";
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}
?>