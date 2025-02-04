<?php 

$routes = [];
session_start();
require 'base.php';

route($base, function(){
    include 'db.php';
    include 'assets.php';
    require 'class/modules/utils.php';
    $ui = new UIInterface();
   
    if (isset($_SESSION['error'])) {
        $ui->ntdotjsx($_SESSION['error'], "danger");
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {
        $ui->ntdotjsx($_SESSION['success'], "success");
        unset($_SESSION['success']);
    }

    if (!isset($_SESSION['user_login'])) {
        include 'views/home.php';
    } else {

        $db = new Database();
        $pdo = $db->getConnect(); 
        
        require 'class/modules/data.php';
        require 'class/modules/users.php';

        $table_food_type = new Data($pdo, 'food_type');
        $table_shop_type = new Data($pdo, 'shop_type');
        $table_shop = new Data($pdo, 'shop');
        $table_food = new Data($pdo, 'food');
        $table_order = new Data($pdo, 'orders');     
        $table_cart = new Data($pdo, 'cart');
        $table_user = new Data($pdo, 'users');
        $user = new Users($pdo);
        $useAuth = $user->useAuth();


        if ($_SESSION['role'] === "admin") {
            include 'views/services/admin.php';
        } elseif ($_SESSION['role'] === "manager") {
            include 'views/services/manager.php';
        } elseif ($_SESSION['role'] === "delivery") {
            include 'views/services/delivery.php';
        } else {
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