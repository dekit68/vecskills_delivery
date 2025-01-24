<?php
    $stmt = $pdo->prepare("SELECT * FROM shop");
    $stmt->execute();
    $shops = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT * FROM food_type");
    $stmt->execute();
    $food_types = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_login']]);
    $order = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT food.*, food.type_id, food.shop_id, shop.name AS shopname, food_type.name AS foodtype FROM food JOIN shop ON food.shop_id = shop.id JOIN food_type ON food.type_id = food_type.id");
    $stmt->execute();
    $listFood = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT cart.*, food.name AS food_name, food.food_img AS food_img FROM cart JOIN food ON food.id = cart.food_id WHERE uses_id = ?");
    $stmt->execute([$_SESSION['user_login']]);
    $cart = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT SUM(qty) FROM cart WHERE uses_id = ?");
    $stmt->execute([$_SESSION['user_login']]);
    $dataCount = $stmt->fetchColumn();

    $all = 0;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <?php 
        include 'widgets/navbar.php'; 
        include 'widgets/modal.php';
    ?>

    <div class="container py-4">
        <?php include 'widgets/status.php'; ?>
        <div class="contents" id="shoptype">
            <div class="row g-2">

                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="" class="form-select" id="filtershop">
                            <option value="">ทั้งหมด</option>
                            <?php foreach($shops as $shop):  ?>
                            <option value="<?= $shop['id'] ?>"><?= $shop['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="">เลือกร้านอาหาร</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="" class="form-select" id="filterfood">
                            <option value="">ทั้งหมด</option>
                            <?php 
                                $XXX = [];
                                foreach($food_types as $food_type):  
                                if (!in_array($food_type['name'], $XXX)):
                            ?>
                            <option value="<?= $food_type['name'] ?>"><?= $food_type['name'] ?></option>
                            <?php 
                                $XXX[] = $food_type['name']; 
                                endif;
                                endforeach; 
                            ?>
                        </select>
                        <label for="">เลือกประเภทอาหาร</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" placeholder="s" class="form-control" id="serach">
                        <label for="">ค้นหา</label>
                    </div>
                </div>

                <?php foreach($listFood as $data): ?>
                <div class="col-md-4 mt-4 food-item" data-foodtype="<?= $data['foodtype'] ?>" data-shopname="<?= $data['shop_id'] ?>">
                    <div class="card position-relative">
                        <?php if (!empty($data['discount']) && $data['discount'] > 0): ?>
                            <div class="position-absolute top-0 start-0">
                                <span class="badge bg-danger text-white p-2">ลด <?= $data['discount'] ?>%</span>
                            </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-center">
                            <img src="<?= $data['food_img'] ?>" class="card-img-top" style="width: auto; height: 200px;">
                        </div>

                        <div class="card-body">
                            <h5 class="card-title"><?= $data['name'] ?></h5>
                            <p class="card-text text-secondary"><?= $data['foodtype'] ?> | <?= $data['shopname'] ?></p>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addcart-<?= $data['id'] ?>">เพิ่มลงตระกล้า</button>
                                    <button class="btn btn-outline-primary btn-sm nav-content" data-content="review-<?= $data['id'] ?>">รีวิว</button>
                                </div>

                                <small class="text-success fw-bold"><?= $data['price'] ?> บาท</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addcart-<?= $data['id'] ?>">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header p-5 pb-3 border-bottom-0">
                                <h5>เพิ่มลงตระกล้า</h5>
                                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                            </div>

                            <div class="modal-body pt-0 p-5">
                                <form action="core/cart.php?type=get" method="post">
                                    <div class="form-floating mb-3">
                                        <input type="text" placeholder="s" value="1" name="qty" class="form-control"
                                            required>
                                        <label>จำนวน</label>
                                    </div>
                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                    <button class="w-100 btn btn-primary">ยืนยัน</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>

        <div class="contents" id="cart">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="fw-5">รายการตระกล้า</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmPay">ชำระเงิน</button>
            </div>

            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่ออาหาร</th>
                        <th></th>
                        <th>จำนวน</th>
                        <th>ราคา</th>
                        <th>ส่วนลด</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cart as $data) :
                        $disss = $data['qty'] * $data['price'] * $data['discount'] / 100;
                        $total = $data['qty'] * $data['price'] - $disss;
                        $all += $total;    
                    ?>
                    <tr>
                        <td><?= $data['id'] ?></td>
                        <td><?= $data['food_name'] ?></td>
                        <td><img src="<?= $data['food_img'] ?>" alt="" width="100px"></td>
                        <td><?= $data['qty'] ?></td>
                        <td><?= $data['price'] ?></td>
                        <td><?= $data['discount'] ?> %</td>
                        <td>
                            <form action="core/cart.php?type=delete" method="post">
                                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                <button type="submit" class="btn btn-danger">ลบ</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-end fw-bold">ราคารวม</td>
                        <td class="fw-bold text-success"><?= $all ?> บาท</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="modal fade" id="confirmPay">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >ยืนยันคำสั่งซื้อ</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="core/cart.php?type=checkout" method="post">
                            <?php foreach ($cart as $data) :?>
                            <div class="list-group mb-3">
                                <div class="list-group-item d-flex justify-content-between align-items-center">

                                    <div>
                                        <h6><?=  $data['name'] ?></h6>
                                        <small class="text-secondary"><?=  $data['qty'] ?> | <?=  $data['price'] ?>
                                            ฿</small>
                                    </div>

                                    <div>
                                        <h6 class="text-danger"><?= $data['discount'] ?> %</h6>
                                        <small class="text-success"><?= $data['price'] * $data['qty'] ?> ฿</small>
                                    </div>

                                </div>
                            </div>
                            <?php endforeach; ?>

                            <input type="hidden" name="id" value="<?= $_SESSION['user_login']; ?>">
                            <button class="btn btn-primary w-100">ยืนยันการชำระเงิน</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="contents" id="oldlist">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h4>ประวัติการสั่งซื้อ</h4>
            </div>

            <?php
                $stmt = $pdo->prepare("SELECT orders.*, CONCAT(users.fname,' ', users.lname) AS username, shop.name AS shopname, users.address AS userAddress, users.phone AS phone  FROM orders LEFT JOIN users ON orders.delivery_id = users.id JOIN shop ON orders.shop_id = shop.id WHERE orders.user_id = ?");
                $stmt ->execute([$_SESSION['user_login']]);
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
                        <th>ชื่อผู้ส่ง</th>
                        <th>ชื่อร้าน</th>
                        <th>สถานะ</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($od as $data):
                        $stmt = $pdo->prepare("SELECT order_detail.*, food.name AS food_name, food.food_img AS food_imgs FROM order_detail JOIN food ON order_detail.food_id = food.id WHERE order_detail.id = ?");
                        $stmt ->execute([$data['id']]);
                        $odd = $stmt->fetchAll();
                    ?>
                    <tr>
                        <td><?= $data['id'] ?></td>
                        <td><?= $data['date'] ?></td>
                        <td><?= ($data['username'] ? $data['username'] : 'ยังไม่มีผู้ส่ง') ?></td>
                        <td><?= $data['shopname'] ?></td>
                        <td><?php if($data['delivery_status'] == 0) { echo 'ยังส่งไม่สำเร็จ'; } else { echo 'ส่งสำเร็จแล้ว'; } ?></td>
                        <td>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirm-<?= $data['id'] ?>">ดูรายละเอียด</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="confirm-<?= $data['id'] ?>" tabindex="-1" aria-labelledby="confirmLabel-<?= $data['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">รายการอาหาร</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $grouped = [];
                                    foreach ($odd as $datas) {
                                        $grouped[$datas['id']][] = $datas;
                                    }

                                    foreach ($grouped as $id => $items):
                                        $all = 0;
                                    ?>
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <?php foreach ($items as $datas): 
                                                $disss = $datas['qty'] * $datas['price'] * $datas['discount'] / 100;
                                                $total = $datas['qty'] * $datas['price'] - $disss;
                                                $all += $total;
                                            ?>
                                            <div class="list-group mb-3">
                                                <div class="list-group-item d-flex justify-content-between align-items-center p-3 rounded border">
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= $datas['food_imgs'] ?>" class="rounded me-3" style="width: 100px; height: 100px; object-fit: cover;">
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">ชื่ออาหาร: <?= $datas['food_name'] ?></h6>
                                                            <p class="mb-0 text-muted small">ราคา: <?= $datas['price'] ?> | จำนวน: <?= $datas['qty'] ?></p>
                                                            <p class="mb-0 text-danger small">ส่วนลด: <?= $datas['discount'] ?>%</p>
                                                            <p class="mb-0 text-success small">ราคารวม: <?= number_format($total, 2) ?> บาท</p>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-outline-primary nav-content" data-bs-dismiss="modal" data-content="review-<?= $datas['food_id'] ?>">รีวิว</button>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                            <p class="fw-bold text-end text-primary">รวมทั้งหมด: <?= number_format($all, 2) ?> บาท</p>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php include 'widgets/review.php'; ?>
        <?php include 'widgets/profile.php'; ?>
    </div>
</body>

</html>