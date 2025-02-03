<?php
require_once 'users.php';
require_once '../db.php';

$db = new Database();
$pdo = $db->getConnect();

$auth = new Auth($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        if ($auth->login()) {
            header("Location: /");
            exit;
        } else {
            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == 'register') {
        if ($auth->register()) {
            echo '<p style="color: green;">ลงทะเบียนสำเร็จ</p>';
        } else {
            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
        }
    }
}
?>

<h1>Login</h1>
<form action="" method="post">
    <input type="hidden" name="action" value="login">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required placeholder="Enter your email">

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required placeholder="Enter your password">

    <button type="submit">Login</button>
</form>

<h1>Register</h1>
<form action="" method="post">
    <input type="hidden" name="action" value="register">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required placeholder="Enter your email">

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required placeholder="Enter your password">

    <label for="role">Role:</label>
    <select name="role" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>

    <label for="fname">First Name:</label>
    <input type="text" id="fname" name="fname" required placeholder="First Name">

    <label for="lname">Last Name:</label>
    <input type="text" id="lname" name="lname" required placeholder="Last Name">

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required placeholder="Address">

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" required placeholder="Phone Number">

    <button type="submit">Register</button>
</form>