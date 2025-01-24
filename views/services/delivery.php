<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery</title>
</head>

<body>
    <?php 
        include 'widgets/navbar.php'; 
        include 'widgets/modal.php';
    ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="contents" id="menus">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h4>รับรายการอาหาร</h4>
                    </div>
                    <?php
                        $stmt = $pdo->prepare("SELECT orders.*, CONCAT(users.fname,' ', users.lname) AS username, shop.name AS shopname, users.address AS userAddress, users.phone AS phone  FROM orders JOIN users ON orders.user_id = users.id JOIN shop ON orders.shop_id = shop.id WHERE delivery_status = 0 AND delivery_id IS NULL");
                        $stmt ->execute();
                        $od = $stmt->fetchAll();
                    
                        foreach ($od as $data) {
                            $stmt = $pdo->prepare("SELECT order_detail.*, food.name AS food_name FROM order_detail JOIN food ON order_detail.food_id = food.id WHERE order_detail.id = ?");
                            $stmt ->execute([$data['id']]);
                            $odd = $stmt->fetchAll();
                        }
                    ?>
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>เวลา</th>
                                <th>ชื่อผู้สั่ง</th>
                                <th>ชื่อร้าน</th>
                                <th>การจัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($od as $data):
                                $stmt = $pdo->prepare("SELECT order_detail.*, food.name AS food_name FROM order_detail JOIN food ON order_detail.food_id = food.id WHERE order_detail.id = ?");
                                $stmt ->execute([$data['id']]);
                                $odd = $stmt->fetchAll();
                        ?>
                            <tr>
                                <td>
                                    <?= $data['id'] ?>
                                </td>
                                <td>
                                    <?= $data['date'] ?>
                                </td>
                                <td>
                                    <?= $data['username'] ?>
                                </td>
                                <td>
                                    <?= $data['shopname'] ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#confirm-<?= $data['id'] ?>">รับรายการอาหาร</button>
                                    <button class="btn btn-outline-dark" data-bs-toggle="modal"
                                        data-bs-target="#doData-<?= $data['id'] ?>">ดูข้อมูลผู้สั่ง</button>
                                </td>
                            </tr>

                            <div class="modal fade" id="confirm-<?= $data['id'] ?>">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>ยืนยันการรับรายการอาหาร
                                                <?= $data['id'] ?>
                                            </h5>
                                            <button class="btn-close" data-bs-dismiss="modal"
                                                aria-label="close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="core/delivery.php?type=apply" method="post">
                                                <?php foreach($odd as $datas): ?>
                                                <div class="list-group mb-3">
                                                    <div
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6>ชื่ออาหาร :
                                                                <?= $datas['food_name'] ?>
                                                            </h6>
                                                            <small class="text-secondary">ราคา :
                                                                <?= $datas['price'] ?>
                                                                | จำนวน :
                                                                <?= $datas['qty'] ?>
                                                            </small>
                                                        </div>
                                                        <input type="hidden" name="id" value="<?= $data['id'] ?>">

                                                        <div>
                                                            <h6>ส่วนลด
                                                                <?= $datas['discount'] ?>
                                                            </h6>
                                                            <small class="text-success">ราคารวม :
                                                                <?= $datas['total_price'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>

                                                <button class="btn btn-primary w-100">ยืนยันการชำระเงิน</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="confirm-<?= $data['id'] ?>">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>ยืนยันการรับรายการอาหาร</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"
                                                aria-label="close"></button>
                                        </div>


                                        <div class="modal-body">
                                            <form action="">
                                                <div class="list-group mb-3">
                                                    <div
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6>ชื่ออาหาร :
                                                                <?= $datas['food_name'] ?>
                                                            </h6>
                                                            <small class="text-secondary">ราคา :
                                                                <?= $datas['price'] ?>
                                                                | จำนวน :
                                                                <?= $datas['qty'] ?>
                                                            </small>
                                                        </div>

                                                        <div>
                                                            <h6>ส่วนลด
                                                                <?= $datas['discount'] ?>
                                                            </h6>
                                                            <small class="text-success">ราคารวม :
                                                                <?= $datas['total_price'] ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>


                                                <button class="btn btn-primary w-100">ยืนยันการชำระเงิน</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="doData-<?= $data['id'] ?>">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>ข้อมูลผู้สั่ง</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"
                                                aria-label="close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="">

                                                <div class="list-group mb-3">
                                                    <div
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6>ชื่อ-นามสกุล :
                                                                <?= $data['username'] ?>
                                                            </h6>
                                                            <small class="text-secondary">ที่อยู่ :
                                                                <?= $data['userAddress'] ?> | เบอร์โทร :
                                                                <?= $data['phone'] ?>
                                                            </small>
                                                        </div>

                                                        <div>
                                                            <h6>ชื่อร้าน
                                                                <?= $data['shopname'] ?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>


                                                <button class="btn btn-primary w-100">ยืนยันการชำระเงิน</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

    <div class="row justify-content-center">
        <div class="contents" id="confirmfood">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h4>รับรายการอาหาร</h4>
            </div>
            <?php
                $stmt = $pdo->prepare("SELECT orders.*, CONCAT(users.fname,' ', users.lname) AS username, shop.name AS shopname, users.address AS userAddress, users.phone AS phone  FROM orders JOIN users ON orders.user_id = users.id JOIN shop ON orders.shop_id = shop.id WHERE delivery_status = 0 AND delivery_id IS NULL");
                $stmt ->execute();
                $od = $stmt->fetchAll();
            ?>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>เวลา</th>
                        <th>ชื่อผู้สั่ง</th>
                        <th>ชื่อร้าน</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $stmt = $pdo->prepare("SELECT orders.*, CONCAT(users.fname,' ', users.lname) AS username, shop.name AS shopname, users.address AS userAddress, users.phone AS phone  FROM orders JOIN users ON orders.user_id = users.id JOIN shop ON orders.shop_id = shop.id WHERE delivery_status = 0 AND delivery_id = ?");
                    $stmt ->execute([$_SESSION['user_login']]);
                    $ods = $stmt->fetchAll();
                    foreach($ods as $data):
                        $stmt = $pdo->prepare("SELECT order_detail.*, food.name AS food_name FROM order_detail JOIN food ON order_detail.food_id = food.id WHERE order_detail.id = ?");
                        $stmt ->execute([$data['id']]);
                        $odd = $stmt->fetchAll();
                ?>
                <tr>
                    <td><?= $data['id'] ?></td>
                    <td><?= $data['date'] ?></td>
                    <td><?= $data['username'] ?></td>
                    <td><?= $data['shopname'] ?></td>
                    <td>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#doo-<?= $data['id'] ?>">ดูรายการอาหาร</button>
                        <form action="core/delivery.php?type=apply_payment" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                            <button class="btn btn-success">ยืนยันรายการอาหาร</button>
                        </form>
                        <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#doData-<?= $data['id'] ?>">ดูข้อมูลผู้สั่ง</button>
                    </td>
                </tr>
                <div class="modal fade" id="doo-<?= $data['id'] ?>">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>ยืนยันการรับรายการอาหาร</h5>
                                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                <?php foreach($odd as $datas): ?>
                                    <div class="list-group mb-3">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <h6><?= $datas['food_name'] ?></h6>
                                            <small class="text-secondary">ราคา <?= $datas['price'] ?> | จำนวน <?= $datas['qty'] ?></small>
                                        </div>
                                        <h6>ส่วนลด <?= $datas['discount'] ?>
                                                                </h6>
                                                                <small class="text-success">ราคารวม :
                                                                    <?= $datas['total_price'] ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>

                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" id="confirm-<?= $data['id'] ?>">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5>ยืนยันการรับรายการอาหาร</h5>
                                                <button class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="">
                                                    <div class="list-group mb-3">
                                                        <div
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6>ชื่ออาหาร :
                                                                    <?= $datas['food_name'] ?>
                                                                </h6>
                                                                <small class="text-secondary">ราคา :
                                                                    <?= $datas['price'] ?> | จำนวน :
                                                                    <?= $datas['qty'] ?>
                                                                </small>
                                                            </div>
                                                            <div>
                                                                <h6>ส่วนลด
                                                                    <?= $datas['discount'] ?>
                                                                </h6>
                                                                <small class="text-success">ราคารวม :
                                                                    <?= $datas['total_price'] ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary w-100">ยืนยันการชำระเงิน</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="doData-<?= $data['id'] ?>">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5>ข้อมูลผู้สั่ง</h5>
                                                <button class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="">
                                                    <div class="list-group mb-3">
                                                        <div
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6>ชื่อ-นามสกุล :
                                                                    <?= $data['username'] ?>
                                                                </h6>
                                                                <small class="text-secondary">ที่อยู่ :
                                                                    <?= $data['userAddress'] ?> | เบอร์โทร :
                                                                    <?= $data['phone'] ?>
                                                                </small>
                                                            </div>

                                                            <div>
                                                                <h6>ชื่อร้าน
                                                                    <?= $data['shopname'] ?>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary w-100">ยืนยันการชำระเงิน</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
    <?php include 'widgets/profile.php'; ?>
</body>
</html>