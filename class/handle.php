<?php 
session_start();
header("location: /"); // 🔥 can comment for debug mode 55555555
require_once '../db.php';
require_once 'modules/data.php';
require_once 'modules/user.php';
$db = new Database();
$pdo = $db->getConnect();
$user = new Users($pdo);
$dataHandler = new Data($pdo, NULL);
$useAuth = $user->useAuth();

$shopId = $useAuth['shop']['id'] ?? null;
$userId = $useAuth['user']['id'] ?? null;

$deleteParams = [
    'delete_user' => 'users',
    'delete_cart' => 'cart',
    'delete_shop' => 'shop',
    'delete_shop_type' => 'shop_type',
    'delete_food_type' => 'food_type',
    'delete_food' => 'food'
];

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
    $user->logout();
}

if (isset($_POST['add_food_type'])) {
    $name = $_POST['name'];
    $dataHandler->add('food_type', 'name, shop_id', '? , ?', [$name, $shopId]);

    if ($dataHandler) {
        $_SESSION['success'] = "เพิ่ม $name สำเร็จ";
    }
}

if (isset($_POST['add_shop_type'])) {
    $name = $_POST['name'];
    $dataHandler->add('shop_type', 'name', '?', [$name]);

    if ($dataHandler) {
        $_SESSION['success'] = "เพิ่ม $name สำเร็จ";
    }
}

if (isset($_POST['update_password'])) {
    $OP = $_POST['OP'];
    $NP = $_POST['NP'];
    if ($OP != $useAuth['user']['password']) {
        $_SESSION['error'] = "รหัสเดิมไม่ถูก";
    } else {
        if ($NP == $useAuth['user']['password']) {
            $_SESSION['error'] = "ตั้งรหัสเดิมทำไม";
        } else {
            $dataHandler->update('users', 'password = ?', 'id = ?', [$NP, $useAuth['user']['password']]);
            $_SESSION['success'] = "เปลี่ยนรหัส สำเร็จ";
        }
    }
}

if (isset($_POST['update_profile'])) {
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $image = NULL;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $new = time() .'_'. $_FILES['image']['name'];
        $dir = './uploads/' . $new;
        $image = '/class/uploads/'. $new;
        move_uploaded_file($_FILES['image']['tmp_name'], $dir);
    }

    if ($image) {
        $dataHandler->update('users', 'email = ?, fname = ?, lname = ?, address = ?, phone = ?, image = ?', 'id = ?', [$email, $fname, $lname, $address, $phone, $image, $useAuth['user']['id']]);
    } else {
        $dataHandler->update('users', 'email = ?, fname = ?, lname = ?, address = ?, phone = ?', 'id = ?',  [$email, $fname, $lname, $address, $phone, $useAuth['user']['id']]);
    }

    if ($dataHandler) {
        $_SESSION['success'] = "อัพเดท $email สำเร็จ";
    }
}


if (isset($_POST['update_food'])) {
    $ide = $_GET['e'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $image = NULL;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $new = time() .'_'. $_FILES['image']['name'];
        $dir = './uploads/' . $new;
        $image = '/class/uploads/'. $new;
        move_uploaded_file($_FILES['image']['tmp_name'], $dir);
    }

    if ($image) {
        $dataHandler->update('food', 'name = ?, type_id = ?, price = ?, discount = ?, image = ?', 'id = ?', [$name, $type, $price, $discount, $image, $ide]);
    } else {
        $dataHandler->update('food', 'name = ?, type_id = ?, price = ?, discount = ?', 'id = ?', [$name, $type, $price, $discount, $ide]);
    }

    if ($dataHandler) {
        $_SESSION['success'] = "อัพเดท $name สำเร็จ";
    }
}

if (isset($_POST['add_food'])) {
    $name = $_POST['name'];
    $type = $_POST['type_id'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $image = NULL;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $new = time() .'_'. $_FILES['image']['name'];
        $dir = './uploads/' . $new;
        $image = '/class/uploads/'. $new;
        move_uploaded_file($_FILES['image']['tmp_name'], $dir);
    }

    if ($image) {
        $dataHandler->add('food', 'name, type_id, price, discount, image, shop_id', '?,?,?,?,?,?', [$name, $type, $price, $discount, $image, $shopId]);
    } else {
        $dataHandler->add('food', 'name, type_id, price, discount, shop_id', '?,?,?,?,?', [$name, $type, $price, $discount, $shopId]);
    }

    if ($dataHandler) {
        $_SESSION['success'] = "เพิ่ม $name สำเร็จ";
    }
}

if (isset($_POST['add_cart'])) {
    $id = $_POST['food'];
    $qty = $_POST['qty'];
    $oncart = $dataHandler->get1("SELECT * FROM cart WHERE user_id = $userId");
    $food = $dataHandler->get1("SELECT * FROM food WHERE id = $id");
    $name = $food['name'];

    var_dump($oncart);
    if ($oncart) {
        if ($id == $oncart['food_id']) {
            $dataHandler->update('cart', 'qty = ?', 'food_id = ?', [$oncart['qty'] + $qty, $id]);
        } else {
            $dataHandler->add('cart', 'name, price, discount, qty, shop_id, food_id, user_id', '?,?,?,?,?,?,?', [$food['name'], $food['price'], $food['discount'], $qty, $food['shop_id'],$food['id'], $userId ]);
        }
    } else {
        $dataHandler->add('cart', 'name, price, discount, qty, shop_id, food_id, user_id', '?,?,?,?,?,?,?', [$food['name'], $food['price'], $food['discount'], $qty, $food['shop_id'],$food['id'], $userId ]);
    }
    
    if ($dataHandler) { 
        $_SESSION['success'] = "เพิ่ม $name จำนวน $qty สำเร็จ";
    }
}

if (isset($_POST['send_shop'])) {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $dataHandler->add('shop', 'name, type_id, address, phone, user_id', '?,?,?,?,?', [$name, $type, $address, $phone, $useAuth['user']['id']]);
}

if (isset($_GET['active'])) {
    $ad = $_GET['active'];
    echo $ad;
    $sa = $dataHandler->get1("SELECT * FROM shop WHERE id = $ad");
    $name = $sa['name'];
    if ($sa['status'] == 0) {
        $dataHandler->update('shop', 'status = ?', 'id = ?', [1, $ad]);
        $_SESSION['success'] = "อนุมัติ $name สำเร็จ";
    } else {
        $dataHandler->update('shop', 'status = ?', 'id = ?', [0, $ad]);
        $_SESSION['error'] = "ยกเลิก $name สำเร็จ";
    }
} 
if (isset($_GET['access'])) {
    $ad = $_GET['access'];
    $sa = $dataHandler->get1("SELECT * FROM users WHERE id = $ad");
    $name = $sa['fname'];
    if ($sa['status'] == 0) {
        $dataHandler->update('users', 'status = ?', 'id = ?', [1, $ad]);
        $_SESSION['success'] = "อนุมัติ $name สำเร็จ";
    } else {
        $dataHandler->update('users', 'status = ?', 'id = ?', [0, $ad]);
        $_SESSION['error'] = "ยกเลิก $name สำเร็จ";
    }
} 

if (isset($_GET['app'])) {
    $ad = $_GET['app'];
    $dataHandler->update('orders', 'delivery_id = ?', 'id = ?', [$userId, $ad]);
    $_SESSION['success'] = "รับแล้ว $ad สำเร็จ";
} 

if (isset($_GET['apc'])) {
    $ad = $_GET['apc'];
    $dataHandler->update('orders', 'delivery_status = ?', 'id = ?', [1, $ad]);
    $_SESSION['success'] = "ยืนยัน $ad สำเร็จ";
} 

foreach ($deleteParams as $param => $table) {
    if (isset($_GET[$param])) {
        $id = $_GET[$param];
        $dataHandler->delete($table, 'id = ?', $id);
        if ($dataHandler) {
            $_SESSION['success'] = "ลบสำเร็จ";
        }
    }
}

if (isset($_GET['checkout'])){
    $dataHandler->checkout($useAuth['user']['id']);
}
?>