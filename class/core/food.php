<?php

require '../db.php';
session_start();
header("location: $base");

if ($_GET['type'] === "add") {
    $shop_id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    // $food_img = NULL;

    if (isset($_FILES['food_img']) && $_FILES['food_img']['error'] === UPLOAD_ERR_OK) {
        $newName = time() .'_'. $_FILES['food_img']['name'];
        $uploadDir = '../uploads/food/'. $newName;
        $food_img = $url.$base.'uploads/food/'.$newName;
        move_uploaded_file($_FILES['food_img']['tmp_name'], $uploadDir);
        try {
            $stmt = $pdo->prepare("INSERT INTO food (name, price, discount, food_img, type_id, shop_id) VALUES (?,?,?,?,?,?)");
            $stmt -> execute([$name, $price, $discount, $food_img, $type, $shop_id]);
            $_SESSION['success'] = "อัพเดทโปรไฟล์ $name $price $ สำเร็จ";
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
} else {
    $_SESSION['error'] = "กรุณาใส่รูป";
}

} elseif ($_GET['type'] === "delete") {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM food WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = "ลบออกแล้ว";
} elseif ($_GET['type'] === "update") {
    $id = $_POST['id'];
    echo $id;
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $food_img = NULL;

    if (isset($_FILES['food_img']) && $_FILES['food_img']['error'] === UPLOAD_ERR_OK) {
        $newName = time() .'_'. $_FILES['food_img']['name'];
        $uploadDir = '../uploads/food/'. $newName;
        $food_img = $url.$base.'uploads/food/'.$newName;
        move_uploaded_file($_FILES['food_img']['tmp_name'], $uploadDir);
    }

    try {
        $stmt = $pdo->prepare("UPDATE food SET name = ?, type_id = ?, price = ?, discount = ? ". ($food_img ? ', food_img = ?':'')." WHERE id = ?");
        $param = [$name, $type, $price, $discount];
        if ($food_img) $param[] = $food_img;
        $param[] = $id;
        $stmt -> execute($param);
        $_SESSION['success'] = "อัพเดทโปรไฟล์ $name $price $ สำเร็จ";
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }

} elseif ($_GET['type'] === "addtype") {
    $id = $_POST['id'];
    $name = $_POST['name'];

    try {
        $stmt = $pdo->prepare("INSERT INTO food_type (name, shop_id) VALUES (?, ?)");
        $stmt->execute([$name, $id]);
        $_SESSION['success'] = "เพิ่มประเภท $name สำเร็จ";
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }

} elseif ($_GET['type'] === "deletetype") {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM food_type WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = "ลบออกแล้ว";
}
?>