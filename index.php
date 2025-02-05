<?php 
$routes = [];
session_start();

require_once 'db.php';
require_once 'class/modules/utils.php';
require_once 'class/modules/data.php';
require_once 'class/modules/users.php';

route('/', function(){
    global $interface;
    global $useAuth;
    global $dataHandler;
    
    loadRequirement();
    // Session-based Notifications
    foreach (['error' => 'danger', 'success' => 'success'] as $data => $type) {
        if (isset($_SESSION[$data])) {
            $interface->ntdotjsx($_SESSION[$data], $type);
            unset($_SESSION[$data]);
        }
    }

    // Authentication Check
    if (!isset($_SESSION['user_login'])) {
        include 'views/home.php';
    } else {        
        // Role-based Routing
        $role = $_SESSION['role'] ?? 'user';
        $ViewMap = [
            'admin'    => 'views/services/admin.php',
            'manager'  => 'views/services/manager.php',
            'delivery' => 'views/services/delivery.php',
            'user'     => 'views/services/user.php',
        ];
        loadRequirement();
        include $ViewMap[$role] ?? 'views/services/user.php';
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
    global $interface;
    global $useAuth;
    global $dataHandler;
    $db = new Database();
    $pdo = $db->getConnect(); 
    $dataHandler = new Data($pdo, NULL); 
    $userManager = new Users($pdo); 
    $useAuth = $userManager->useAuth();
    $interface = new UIInterface();
    require_once 'widgets/assets.php';
}
?>