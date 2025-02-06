<?php
    $user_id = $useAuth['user']['id'];
    $all_shop = $dataHandler->get("SELECT * FROM shop");
    $all_food_type = $dataHandler->get("SELECT DISTINCT * FROM food_type");
    $all_cart = $dataHandler->get("SELECT * FROM cart WHERE user_id = $user_id");
    $all_food = $dataHandler->get("SELECT food.*, food_type.name as foodtype, shop.name as shopname, food_type.id as foodtypeid, shop.id as shopid FROM food JOIN food_type ON food.type_id = food_type.id JOIN shop ON food.shop_id = shop.id");
    $all_order = $dataHandler->get("SELECT orders.*, CONCAT(users.fname,' ', users.lname) AS delivery_name, shop.name AS shop_name, users.address AS userAddress, users.phone AS phone  FROM orders LEFT JOIN users ON orders.delivery_id = users.id JOIN shop ON orders.shop_id = shop.id WHERE orders.user_id = $user_id");
    $all = 0;
    $totalP = 0;
    $totalD = 0;
    $totalOP = 0;
    foreach($all_cart as $data): 
        $p = $data['price'];
        $q = $data['qty'];
        $d = $data['discount'];
        $dAmount = $p * $q * ($d / 100);
        $totalP += ($p * $q) - $dAmount; 
        $totalD += $dAmount; 
        $totalOP += ($p * $q);
    endforeach;
    $discountPercentage = $totalOP > 0 ? round(($totalD / $totalOP) * 100) : 0;
?>

<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-12">
            <div class="contents" id="content_main">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="m-0">รายการอาหาร</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="serach" placeholder="ss">
                                    <label for="">ค้นหา..</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 g-2">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="" class="form-select" id="filterfood">
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach($all_food_type as $data): ?>
                                    <option value="<?= $data['id'] ?>">
                                        <?= $data['name'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="">เลือกประเภทอาหาร</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="" class="form-select" id="filtershop">
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach($all_shop as $data): ?>
                                    <option value="<?= $data['id'] ?>">
                                        <?= $data['name'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="">เลือกร้านอาหาร</label>
                            </div>
                        </div>

                        <?php foreach($all_food as $data): ?>
                        <div class="col-md-3 mt-4 food-item" data-shopname="<?= $data['shopid'] ?>" data-foodtype="<?= $data['foodtypeid'] ?>">
                            <div class="card shadow-sm">
                                <div style="position: absolute;">
                                    <span class="badge mt-2 ms-2 bg-light text-danger">ส่วนลด <?= $data['discount'] ?> %
                                    </span>
                                </div>
                                <img src=" <?= $data['image'] ?>" class="card-img-top" width="100px" height="300px" alt="Nopic">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <?= $data['name'] ?>
                                    </h4>
                                    <small class="card-text text-secondary">
                                        <?= $data['foodtype'] ?> |
                                        <?= $data['shopname'] ?>
                                    </small><br>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-success">
                                                <?= $data['price'] ?> ฿
                                            </small>
                                        </div>
                                        <button class="btn btn-primary rounded-pill btn-sm" data-bs-toggle="modal" data-bs-target="#addcart-<?= $data['id'] ?>">เพิ่มลงตะกร้า</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="contents" id="content_cart">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="m-0">ตะกล้า</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="w-100 h-100">
                                    <a class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#confirm-order">สั่งเลย</a>
                                </div>
                            </div>
                        </div>
                    </div>
           
                    <div class="table-responsive">
                        <table class="table text-center" id="userTable">
                            <thead>
                                <tr>
                                    <th>ชื่อรายการ</th>
                                    <th>จำนวน</th>
                                    <th>ส่วนลด</th>
                                    <th>ราคา</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($all_cart as $data): 
                                    $con = $data['price'] * $data['qty'];
                                    $all += $con;
                                ?>
                                <tr>
                                    <td><?= $data['name'] ?></td>
                                    <td><?= $data['qty'] ?> จำนวน</td>
                                    <td><?= $data['discount'] ?> %</td>
                                    <td><?= $data['price'] ?> ฿</td>
                                    <th><button data-bs-toggle="modal" data-bs-target="#delete_cart=<?= $data['id'] ?>" class="btn btn-danger btn-sm">🗑️</button></th>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="4" class="text-end">ทั้งหมด</td>
                                    <td><?= $all ?> บาท</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>  
                </div>
            </div>

            <div class="contents" id="content_history">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="m-0">ประวัติการสั่งซื้อ</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center" id="userTable">
                            <thead>
                                <tr>
                                    <th>ไอดี</th>
                                    <th>เวลา</th>
                                    <th>ผู้ส่ง</th>
                                    <th>สถานะการส่ง</th>
                                    <th>ร้าน</th>
                                    <th>รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($all_order as $data): ?>
                                <tr>
                                    <td><?= $data['id'] ?></td>
                                    <td><?= $data['time'] ?></td>
                                    <th><?= $data['delivery_name'] ? $data['delivery_name'] : 'ยังไม่มีผู้ส่ง' ?></th>
                                    <td><?= $data['delivery_status'] == 0 ? '🚚 กำลังจัดส่ง' : '✅ จัดส่งแล้ว'; ?></td>

                                    <td><?= $data['shop_name'] ?></td>
                                    <td><button  class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#order-<?= $data['id'] ?>">ดูรายละเอียด</button></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>
            <?php include 'widgets/content.php' ?>
        </div>
    </div>
</div>

<!-- Modal User -->
<?php foreach($all_food as $data): ?>
<div class="modal fade" id="addcart-<?= $data['id'] ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-5 pb-3 border-bottom-0">
                <h5>เพิ่ม <?= $data['name'] ?>  ลงตระกล้า</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body pt-0 p-5">
                <form action="class/handle.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" placeholder="s" value="1" name="qty" class="form-control"required>
                        <label>จำนวน</label>
                    </div>
                    <input type="hidden" name="food" value="<?= $data['id'] ?>">
                    <button class="w-100 btn btn-primary" name="add_cart">ยืนยัน</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<div class="modal fade" id="confirm-order">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <?php if (!$totalD == 0) { ?>
            <div class="modal-header border-bottom-0">
                <h3>ตรวจสอบก่อนสั่งซื้อ</h3>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body">
                <p>ส่วนลด: <span class="text-danger">- <?= number_format($totalD, 2) ?> ฿</span></p>
                <p>ส่วนลดรวม: <span class="text-danger"><?= $discountPercentage ?>%</span></p>
                <p>ราคารวม (ก่อนลด): <span class="text-muted text-decoration-line-through"><?= number_format($totalOP, 2) ?></span> <span class="text-success"><?= number_format($totalP, 2) ?> ฿</span></p>
                <a class="btn btn-primary mt-2 w-100" href="class/handle.php?checkout=<?= $useAuth['user']['id'] ?>">ยืนยันการสั่งซื้อ</a>
            </div>
            <?php } else { ?>
                <div class="modal-body text-center">
                <h1>ไปหยิบลงตะกล้าก่อนดิ</h1>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php 
foreach($all_order as $data): 
    $od = $data['id'];
    $all_order_detail = $dataHandler->get("
    SELECT order_detail.*, 
           food.name AS food_name, 
           food.price AS food_price, 
           food.discount AS food_discount, 
           food_type.name AS food_type_name, 
           shop.name AS shop_name 
    FROM order_detail
    JOIN food ON food.id = order_detail.food_id 
    JOIN food_type ON food_type.id = food.type_id
    JOIN shop ON shop.id = food.shop_id 
    WHERE order_detail.id = $od
");
    $grouped = [];
    $totalOrderP = 0; 
    foreach ($all_order_detail as $datas) {
        $grouped[$datas['id']][] = $datas;
    }
    foreach ($grouped as $id => $items):
?>
<div class="modal fade" id="order-<?= $data['id'] ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3>รายละเอียดคำสั่งซื้อ #<?= $data['id'] ?></h3>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body">
                <form action="class/handle.php" method="post">
                    <div class="list-group">
                    <?php foreach ($items as $item):
                        $pAfterD = $item['food_price'] * (1 - $item['food_discount'] / 100);
                        $totalItemP = $pAfterD * $item['qty'];
                        $totalOrderP += $totalItemP;
                    ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <small class="fw-bold"><?= $item['food_name'] ?></small>
                                <small><?= $item['food_type_name'] ?> | <?= $item['shop_name'] ?></small><br>
                                <small class="text-success"><?= number_format($item['food_price'], 2) ?> ฿</small> |
                                <small class="text-danger">ส่วนลด <?= $item['food_discount'] ?> %</small><br>
                                <small>จำนวน: <?= $item['qty'] ?> ชิ้น</small><br>
                                <small>ราคารวม (หลังส่วนลด): <?= number_format($totalItemP, 2) ?> ฿</small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <div class="mt-3">
                        <h4 class="text-end">ราคารวมทั้งหมด: <span class="text-success"><?= number_format($totalOrderP, 2) ?> ฿</span></h4>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endforeach; ?>

<?php
foreach ($all_cart as $data) {
    $interface->ConA('ลบ '.$data['name'].' ออกจากตะกร้า ', 'กดยืนยันเพื่อลบ '.$data['name'].' 🎯', 'danger', 'delete_cart='.$data["id"].'');
}
?>