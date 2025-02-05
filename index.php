<?php 
$routes = [];
session_start();

route('/', function(){
    loadRequirement();
    $ui = new UIInterface();
    // Session-based Notifications
    foreach (['error' => 'danger', 'success' => 'success'] as $key => $type) {
        if (isset($_SESSION[$key])) {
            $ui->ntdotjsx($_SESSION[$key], $type);
            unset($_SESSION[$key]);
        }
    }

    // Authentication Check
    if (!isset($_SESSION['user_login'])) {
        include 'views/home.php';
    } else {        
        // Role-based Routing
        $role = $_SESSION['role'] ?? 'user';
        $roleViewMap = [
            'admin'    => 'views/services/admin.php',
            'manager'  => 'views/services/manager.php',
            'delivery' => 'views/services/delivery.php',
            'user'     => 'views/services/user.php',
        ];
        include $roleViewMap[$role] ?? 'views/services/user.php';
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

function loadRequirement() {
    require_once 'db.php';
    require_once 'class/modules/utils.php';
    require_once 'class/modules/data.php';
    require_once 'class/modules/users.php';
    $database = new Database();
    $dbConnect = $database->getConnect(); 
    $dataHandler = new Data($dbConnect, NULL); 
    $userManager = new Users($dbConnect); 
    $useAuth = $userManager->useAuth();
    require_once 'widgets/assets.php';
}
?>