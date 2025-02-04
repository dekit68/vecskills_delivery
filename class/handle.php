<?php
session_start();
header('location: /');
require '../db.php';
require 'modules/users.php';
require 'modules/data.php';
$db = new Database();
$pdo = $db->getConnect(); 
$user = new Users($pdo);
$table_food_type = new Data($pdo, 'food_type');
$table_shop_type = new Data($pdo, 'shop_type');
$table_shop = new Data($pdo, 'shop');
$table_food = new Data($pdo, 'food');
$table_order = new Data($pdo, 'orders');     
$table_cart = new Data($pdo, 'cart');
$table_user = new Data($pdo, 'users');

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $user->register($email, $password, $role, $fname, $lname, $address, $phone);
}

if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user->login($email, $password);
}

if (isset($_GET['logout'])) {
    $user->logOut();
}

if (isset($_POST['add_shop_type'])) {
    $name = $_POST['name'];
    $table_shop_type->add('name', '?', [$name]);
}

?>