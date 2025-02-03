<?php
session_start();
require '../db.php';
require 'modules/users.php';
$db = new Database();
$pdo = $db->getConnect(); 
$user = new Users($pdo);

if (isset($_POST['signup'])) {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->role = $_POST['role'];
    $user->fname = $_POST['fname'];
    $user->lname = $_POST['lname'];
    $user->address = $_POST['address'];
    $user->phone = $_POST['phone'];

    if ($user->register()) {
        echo "Registration successful!";
    } else {
        echo "Registration failed.";
    }
    exit;
}

if (isset($_POST['signin'])) {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if ($user->isEmailExists($user->email)) {
        if ($user->verifyPassword()) {
            echo "Login successful!";
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Email not found.";
    }
}

if (isset($_GET['logout'])) {
    $user->logOut();
    exit();
}

?>