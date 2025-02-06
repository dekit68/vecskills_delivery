<?php
session_start();
// header('location: /');
require '../db.php';
require 'modules/users.php';
require 'modules/data.php';
$db = new Database();
$pdo = $db->getConnect(); 
$user = new Users($pdo);
$dataHandler = new Data($pdo, NULL); 
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

if (isset($_POST['update_profile'])) {
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $image = NULL;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $new = time(). '_' . $_FILES['image']['name'];
        $dir = './uploads/'. $new; $image = '/class/uploads/' . $new;
        move_uploaded_file($_FILES['image']['tmp_name'], $dir);
    }
    if (!$image) {
        $table_user->update('email = ?, fname = ?, lname = ?, address = ?, phone = ?', 'id = ?', [$email, $fname, $lname, $address, $phone, $_SESSION['user_login']]);
    } else {
        $table_user->update('email = ?, fname = ?, lname = ?, address = ?, phone = ?, image = ?', 'id = ?', [$email, $fname, $lname, $address, $phone, $image, $_SESSION['user_login']]);
    }
}

if (isset($_GET['delete_type'])) {
    $table_shop_type->delete('id = ?', [$_GET['delete_type']]);
}

if (isset($_GET['checkout'])) {
    $dataHandler->CheckOut($_GET['checkout']);
}

?>