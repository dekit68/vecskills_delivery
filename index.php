<?php 

$routes = [];
session_start();
require 'base.php';

route($base, function(){
    include 'db.php';
    include 'assets.php';
    if (!isset($_SESSION['user_login'])) {
        include 'views/home.php';
    } else {
        $db = new Database();
        $pdo = $db->getConnect(); 
        require 'class/modules/data.php';
        require 'class/modules/users.php';
        $user = new Users($pdo);
        $useAuth = $user->useAuth();
        if ($_SESSION['role'] === "admin") {
            include 'views/services/admin.php';
        } elseif ($_SESSION['role'] === "manager") {
            include 'views/services/manager.php';
        } elseif ($_SESSION['role'] === "delivery") {
            include 'views/services/delivery.php';
        } else {
            $table_food_type = new Data($pdo, 'food_type');
            $table_shop = new Data($pdo, 'shop');
            $table_food = new Data($pdo, 'food');
            $table_order = new Data($pdo, 'orders');     
            $table_cart = new Data($pdo, 'cart');
            include 'views/services/user.php';
        }
    }
});

function route(string $path, callable $callback){
    global $routes;
    $routes[$path] = $callback;
}

run();

function run() {
    global $routes;
    $uri = $_SERVER['REQUEST_URI'];
    foreach ($routes as $path => $callback) {
        if ($path != $uri) continue;
        $callback();
    }
}

?>