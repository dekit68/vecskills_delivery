<?php
    require_once 'class.php';
    require_once '../db.php';
    header('location: test.php');
    session_start();

    $db = new Database();
    $pdo = $db->getConnect();

    $methodHandler = new MethodHandler($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_GET['controller']) && isset($_GET['method'])) {
            $controller = $_GET['controller'];
            $method = $_GET['method'];
            $methodHandler->handleRequest($controller, $method);
        } else {
            $_SESSION['error'] = "ไม่มี controller หรือ method ถูกส่งมา";
        }
    }
?>