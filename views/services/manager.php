<?php 
$menu = [];
if ($useAuth['shop']) {
    $myshop = $useAuth['shop']['id'];
    $food_type = $dataHandler->get("SELECT * FROM food_type WHERE shop_id = $myshop");
    $menu = $dataHandler->get("SELECT food.*, food_type.name as foodtype, shop.name as shopname, food_type.id as foodtypeid, shop.id as shopid FROM food JOIN food_type ON food.type_id = food_type.id JOIN shop ON food.shop_id = shop.id WHERE shop.id = $myshop");

    $order = $dataHandler->get("SELECT orders.*, CONCAT(users.fname,' ',users.lname) AS username, users.address, users.phone, shop.name as shopname, shop.address as shopaddress FROM orders JOIN users ON orders.user_id = users.id JOIN shop ON orders.shop_id = shop.id WHERE shop.id = $myshop");
}

$shop_type = $dataHandler->get("SELECT * FROM shop_type");
?>

<!-- <div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-12">
  
        </div>
    </div>
</div> -->
<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-12">
    <div class="contents" id="content_main">
        <?php if ($useAuth['shop'] && $useAuth['shop']['status'] == 0) {?>
            <h1>ร้าน <?= $useAuth['shop']['name'] ?> กำลังรอการอนุมัติจาก Admin</h1>
                <?php } elseif ($useAuth['shop'] && $useAuth['shop']['status'] == 1) { ?>
                    <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="m-0">สรุปยอด</h3>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table text-center" id="userTable">
                            <thead>
                                <tr>
                                    <th>เวลา</th>
                                    <th>ลูกค้า</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($order as $data): ?>
                                <tr>
                                    <td><?= $data['time']?> </td>
                                    <td><?= $data['user_id'] ?></td>
                                    <th>
                                        <a href="bill.php?id=<?= $data['id'] ?>">พิมพ์ใบเสร็จ</a>
                                    </th>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>  
                </div>
                </div>
                <?php } else { ?>
                <h1>ขอเปิดร้านค้า</h1>
                <form action="class/handle.php" method="POST">
                    <div class="form-floating mb-2">
                        <input type="name" name="name" class="form-control" placeholder="s" required>
                        <label for="">ชื่อร้าน</label>
                    </div>

                    <div class="form-floating mb-2">
                        <select name="type" class="form-select">
                            <?php foreach ($shop_type as $data):?>
                                <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
                            <?php endforeach;?>
                        </select>
                        <label for="">เลือกประเภทร้าน</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="text" name="address" class="form-control" placeholder="s" required>
                        <label for="">ที่อยู่</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input type="text" name="phone" class="form-control" placeholder="s" required>
                        <label for="">เบอร์โทร</label>
                    </div>

                    <button type="submit" name="send_shop" class="btn btn-primary w-100">ส่ง</button>
                </form>
        <?php } ?>
    </div>

    <div class="contents" id="content_menu">
        <div class="card border-0 shadow-sm p-3">
            <div class="card-header d-flex justify-content-between">
                <h3>รายการอาหาร</h3>
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
                <div class="col-md-10">
                    <div class="form-floating">
                        <select name="" class="form-select" id="filterfood">
                            <option value="">ทั้งหมด</option>
                            <?php foreach($food_type as $food_types): ?>
                            <option value="<?= $food_types['id'] ?>">
                                <?= $food_types['name'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="">เลือกประเภทอาหาร</label>
                    </div>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100 h-100" data-bs-toggle="modal" data-bs-target="#add_food">เพิ่มประเภทอาหาร</button>    
                </div>

                <!-- card รายการอาหาร -->
                <?php foreach($menu as $data): ?>
                    <div class="col-md-3 mt-4 food-item" data-foodtype="<?= $data['foodtypeid'] ?>">
                        <div class="card">
                            <div style="position: absolute;">
                                <span class="badge mt-2 ms-2 bg-light text-danger">ส่วนลด
                                    <?= $data['discount'] ?> %
                                </span>
                            </div>
                            <img src="<?= $data['image'] ?>" class="card-img-top" width="100px" height="300px" alt="FOOD">
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
                                    <button class="btn btn-primary rounded-pill btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#managefood-<?= $data['id'] ?>">จัดการ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="contents" id="content_food_type">
        <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>ประเภทอาหาร</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_food_type">เพิ่มประเภทอาหาร</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ชื่อประเภทอาหาร</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($food_type as $data): ?>
                        <tr>
                            <td>
                                <?= $data['name'] ?>
                            </td>
                            <td>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_food_type=<?= $data['id'] ?>">ลบ</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include 'widgets/content.php'; ?>
</div>

<div class="modal fade" id="add_food_type">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3>เพิ่มข้อมูลประเภทอาหาร</h3>
                <button class="btn-close" data-bs-dismiss="modal" aria-lable="close"></button>
            </div>

            <div class="modal-body">
                <form action="class/handle.php?e=<?= $useAuth['shop']['id'] ?>" method="post">
                    <div class="form-floating mb-2">
                        <input type="text" name="name" class="form-control" placeholder="s">
                        <label for="">ชื่อประเภทอาหาร</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-2" name="add_food_type">เพิ่มข้อมูล</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
foreach ($food_type as $data) {
    $iaa = $data['id'];
    $interface->ConA('แจ้งเตือนลบ ⚠', 'คุณต้องการลบหรือไม่', 'danger',"delete_food_type=$iaa"); 
}
?>

<div class="modal fade" id="add_food">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <?php if (!empty($food_type)) { ?>
            <div class="modal-header">
                <h3>เพิ่มข้อมูลอาหาร</h3>
                <button class="btn-close" data-bs-dismiss="modal" aria-lable="close"></button>
            </div>
            <?php } ?>

            <div class="modal-body">
                <?php if (empty($food_type)) { ?>
                    <h1>ไปเพิ่มประเภทก่อนสิครับ 🎏</h1>
                <?php } else { ?>
                <form action="class/handle.php" method="post" enctype="multipart/form-data">
                    <div class="form-floating mb-2">
                        <input type="text" name="name" class="form-control" placeholder="s">
                        <label for="">ชื่ออาหาร</label>
                    </div>

                    <div class="form-floating mb-2">
                        <select name="type_id" class="form-select">
                            <?php foreach($food_type as $data2): ?>
                                <option value="<?= $data2['id'] ?>"><?= $data2['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label>ประเภทอาหาร</label>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" name="price" class="form-control" placeholder="s">
                                <label>ราคา</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" name="discount" class="form-control" placeholder="s">
                                <label>ส่วนลด</label>
                            </div>
                        </div>
                    </div>
                    <input type="file" name="image" class="form-control">
                    <button type="submit" class="btn btn-primary w-100 mt-2" name="add_food">อัพเดท</button>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php foreach($menu as $data): ?>
<div class="modal fade" id="managefood-<?= $data['id'] ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3>จัดการเมนู <?= $data['name'] ?></h3>
                <button class="btn-close" data-bs-dismiss="modal" aria-lable="close"></button>
            </div>

            <div class="modal-body">
                <form action="class/handle.php?e=<?= $data['id'] ?>" method="post" enctype="multipart/form-data">
                    <div class="form-floating mb-2">
                        <input type="text" name="name" value="<?= $data['name'] ?>" class="form-control" placeholder="s">
                        <label for="">ชื่ออาหาร</label>
                    </div>

                    <div class="form-floating mb-2">
                        <select name="type" class="form-select">
                            <option value="<?= $data['type_id'] ?>"><?= $data['foodtype'] ?></option>
                            <?php foreach($food_type as $data2): ?>
                                <option value="<?= $data2['id'] ?>"><?= $data2['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="">ประเภทอาหาร</label>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" name="price" value="<?= $data['price'] ?>" class="form-control" placeholder="s">
                                <label>ราคา</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" name="discount" value="<?= $data['discount'] ?>" class="form-control" placeholder="s">
                                <label>ส่วนลด</label>
                            </div>
                        </div>
                    </div>
                    <input type="file" name="image" class="form-control">
                    <button type="submit" class="btn btn-primary w-100 mt-2" name="update_food">อัพเดท</button>
                    <a class="btn btn-danger mt-2 w-100" href="class/handle.php?delete_food=<?= $data['id'] ?>">ลบ</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>