<?php

require '../db.php';
session_start();
header("location: $base");

if ($_GET['type'] === "reg") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt -> execute([$email]);
        $UserEx = $stmt->fetch();
    
        if (!$UserEx) {
            if ($role === "admin") {
                $stmt = $pdo->prepare("INSERT INTO users (email, password, role, fname, lname, address, phone, status) VALUES (?,?,?,?,?,?,?,1)");
                $stmt -> execute([$email, $password, $role, $fname, $lname, $address, $phone]);
                $_SESSION['success'] = "ลงทะเบียน $fname $lname สำเร็จ";
            } else {
                $stmt = $pdo->prepare("INSERT INTO users (email, password, role, fname, lname, address, phone) VALUES (?,?,?,?,?,?,?)");
                $stmt -> execute([$email, $password, $role, $fname, $lname, $address, $phone]);
                $_SESSION['success'] = "ลงทะเบียน $fname $lname สำเร็จ";
            }
        } else {
            $_SESSION['error'] = "มีผู้ใช้ $email อยู่แล้ว";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }
} else {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt -> execute([$email]);
        $UserEx = $stmt->fetch();
    
        if ($UserEx) {
            if ($UserEx['status'] == 1) {
                if ($password == $UserEx['password']) {
                    $_SESSION['user_login'] = $UserEx['id'];
                    $_SESSION['role'] = $UserEx['role'];
                    $_SESSION['success'] = "ลงทะเบียนสำเร็จ";
                } else {
                    $_SESSION['error'] = "รหัสผิด";
                }
            } else {
                $_SESSION['error'] = "รอแอดมินอนุมัติ";
            }
        } else {
            $_SESSION['error'] = "ไม่มีผู้ใข้ $email ในระบบ";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}
?>