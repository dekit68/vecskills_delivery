<?php

class MethodHandler {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function handleRequest($controller, $method) {
        if (class_exists($controller)) {
            $controllerInstance = new $controller($this->pdo);
            if (method_exists($controllerInstance, $method)) {
                return $controllerInstance->$method();
            } else {
                $_SESSION['error'] = "Method '$method' ไม่ถูกต้องใน class '$controller'";
                header("Location: errorPage.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Class '$controller' ไม่พบ";
            header("Location: errorPage.php");
            exit;
        }
    }
}

require 'modules/users.php';
require 'modules/data.php';