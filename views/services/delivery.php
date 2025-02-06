<?php
    $ssa = $_SESSION['user_login'];
    $order = $dataHandler->get("SELECT orders.*, CONCAT(users.fname,users.lname) AS username, users.address, users.phone, shop.name as shopname, shop.address as shopaddress FROM orders JOIN users ON orders.user_id = users.id JOIN shop ON orders.shop_id = shop.id WHERE delivery_id IS NULL");
    $orderss = $dataHandler->get("SELECT orders.*, CONCAT(users.fname,users.lname) AS username, users.address, users.phone, shop.name as shopname, shop.address as shopaddress FROM orders JOIN users ON orders.user_id = users.id JOIN shop ON orders.shop_id = shop.id WHERE delivery_id = $ssa AND delivery_status = 0");
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="contents" id="content_req">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>จัดการผู้ใช้งาน</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="text-center table table-hover table-striped" id="userTable">
                            <thead>
                                <tr>
                                    <th>เวลา</th>
                                    <th>ชื่อผู้สั่ง</th>
                                    <th>ที่อยู่</th>
                                    <th>เบอร์</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($order as $orders): 
                                ?>
                                    
                                <tr>
                                    <td><?= $orders['time'] ?></td>
                                    <td><?= $orders['username'] ?></td>
                                    <td><?= $orders['address'] ?></td>
                                    <td><?= $orders['phone'] ?></td>
                                    <td>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#apply_order-<?= $orders['id'] ?>">รับออเดอร์</button>
                                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#detail_user-<?= $orders['id'] ?>">ดูข้อมูลผู้สั่ง</button>
                                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#detail_food-<?= $orders['id'] ?>">ดูข้อมูลรายการอาหาร</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="contents" id="content_apply">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>ยืนยันการชำระเงินสำเร็จ</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="text-center table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>เวลา</th>
                                    <th>ชื่อผู้สั่ง</th>
                                    <th>ที่อยู่</th>
                                    <th>เบอร์</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orderss as $data): 
                                ?>
                                    
                                <tr>
                                    <td><?= $data['time'] ?></td>
                                    <td><?= $data['username'] ?></td>
                                    <td><?= $data['address'] ?></td>
                                    <td><?= $data['phone'] ?></td>
                                    <td>
                                        <a class="btn btn-primary mt-2 w-100" href="class/handle.php?apc=<?= $data['id'] ?>">ยืนยันการชำระเงิน</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php include 'widgets/content.php'; ?>
</div>

<?php foreach($order as $orders): 
 $odd = $dataHandler->get("SELECT order_detail.*, food.name as foodname, food.price as foodprice, food.discount as discount FROM order_detail JOIN food ON order_detail.food_id = food.id  WHERE order_detail.id = $orders[id] ");
?>
    
<div class="modal fade" id="detail_user-<?= $orders['id'] ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3>ข้อมูลผู้สั่ง <?= $orders['id'] ?></h3>
                <button class="btn-close" data-bs-dismiss="modal" aria-lable="close"></button>
            </div>

            <div class="modal-body">
                <form action="class/handle.php?" method="post">
                    <div class="list-group">
                        <div class="list-group-item d-flex align-items-center">
                            <div>
                                <h4 class="text-primary"><?= $orders['username'] ?></h4>
                                <small>ที่อยู่<?= $orders['address'] ?> <br> เบอร์โทร <?= $orders['phone'] ?></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detail_food-<?= $orders['id'] ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3>ข้อมูลรายการอาหาร <?= $orders['id'] ?></h3>
                <button class="btn-close" data-bs-dismiss="modal" aria-lable="close"></button>
            </div>

            <div class="modal-body">
                <form action="class/handle.php?" method="post">
                    <?php foreach($odd as $data): ?>
                    <div class="list-group mb-2">
                        <div class="list-group-item d-flex align-items-center">
                            <div>
                                <h4 class="">ชื่อรายการ <?= $data['foodname'] ?></h4>
                                <small class="text-success"><?= $data['foodprice'] ?> ฿</small>|
                                <small class="text-danger">ส่วนลด <?= $data['discount'] ?> %</small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal รับออเดอร์ -->
<div class="modal fade" id="apply_order-<?= $orders['id'] ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3>ยืนยันการรับออเดอร์ <?= $orders['id'] ?></h3>
                <button class="btn-close" data-bs-dismiss="modal" aria-lable="close"></button>
            </div>

            <div class="modal-body">
                    <?php foreach($odd as $data): ?>
                    <div class="list-group mb-2">
                        <div class="list-group-item d-flex align-items-center">
                            <div>
                                <h4 class=""><?= $data['foodname'] ?></h4>
                                <small class="text-secondary">ชื่อร้าน <?= $orders['shopname'] ?> | ที่อยู่ร้าน <?= $orders['shopaddress'] ?></small><br>
                                <small class="text-success"><?= $data['price'] ?> ฿</small>|
                                <small class="text-danger">ส่วนลด <?= $data['discount'] ?> %</small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <a class="btn btn-primary mt-2 w-100" href="class/handle.php?app=<?= $orders['id'] ?>">รับออเดอร์</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
