<?php 

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "mec_foods";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4;", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_SESSION['user_login'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_login']]);
    $user = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT * FROM shop WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_login']]);
    $hash = $stmt->fetch();
}

require 'base.php';

?>