<?php 
$all_users = $dataHandler->get("SELECT * FROM users WHERE role != 'admin'");
$all_shop_type = $dataHandler->get("SELECT * FROM shop_type");
$all_shop = $dataHandler->get("SELECT shop.*, shop_type.name as type_name FROM shop JOIN shop_type ON shop.type_id = shop_type.id");


foreach ($all_users as $data) {
    $aadpa = $data['id'];
    $email = $data['email'];
    $interface->ConA('แจ้งเตือนลบ', "คุณต้องการลบ $email หรือไม่", 'danger', "delete_user=$aadpa"); 
}

foreach ($all_shop_type as $data) {
    $aadpa = $data['id'];
    $interface->ConA('แจ้งเตือนลบ', 'คุณต้องการลบหรือไม่', 'danger', "delete_shop_type=$aadpa"); 
}
?>

<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-12">
            <div class="contents" id="content_user">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="m-0">รายชื่อผู้ใช้</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="search2" placeholder="ค้นหา..">
                                    <label for="search2">ค้นหา..</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 g-2">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="" class="form-select" id="filterrole">
                                    <option value="">ทั้งหมด</option>
                                    <option value="user">ทั่วไป</option>
                                    <option value="manager">ผู้จัดการ</option>
                                    <option value="delivery">ผู้ส่ง</option>
                                </select>
                                <label for="filterrole">เลือกบทบาท</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="" class="form-select" id="filteraccess">
                                    <option value="">ทั้งหมด</option>
                                    <option value="0">ยัง</option>
                                    <option value="1">อนุมัติแล้ว</option>
                                </select>
                                <label for="filteraccess">อนุมัติยัง</label>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table text-center" id="userTable">
                            <thead>
                                <tr>
                                    <th>ชื่อ-สกุล</th>
                                    <th>ที่อยู่</th>
                                    <th>เบอร์</th>
                                    <th>อีเมล์</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($all_users as $data): ?>
                                <tr data-role="<?= $data['role'] ?>" data-status="<?= $data['status'] ?>">
                                    <td><?= $data['fname'].' '. $data['lname']?> </td>
                                    <td><?= $data['address'] ?></td>
                                    <td><?= $data['phone'] ?></td>
                                    <td><?= $data['email'] ?></td>
                                    <th>
                                        <a href="class/handle.php?access=<?= $data['id'] ?>" class="btn btn-primary btn-sm"><?= $data['status'] ? 'ยกเลิก' : 'อนุมัติ' ?></a>
                                        <button data-bs-toggle="modal" data-bs-target="#delete_user=<?= $data['id'] ?>" class="btn btn-danger btn-sm">🗑️</button>
                                    </th>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>

            <div class="contents" id="content_shop">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="m-0">ร้านอาหาร</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="search3" placeholder="ค้นหา..">
                                    <label>ค้นหา..</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table text-center" id="userTable">
                            <thead>
                                <tr>
                                    <th>ชื่อ-สกุล</th>
                                    <th>ที่อยู่</th>
                                    <th>เบอร์</th>
                                    <th>ประเภทร้าน</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($all_shop as $data): ?>
                                <tr data-status2="<?= $data['status'] ?>">
                                    <td><?= $data['name']?> </td>
                                    <td><?= $data['address'] ?></td>
                                    <td><?= $data['phone'] ?></td>
                                    <td><?= $data['type_name'] ?></td>
                                    <th>
                                        <a href="class/handle.php?active=<?= $data['id'] ?>" class="btn btn-primary btn-sm"><?= $data['status'] ? 'ยกเลิก' : 'อนุมัติ' ?></a>
                                        <button data-bs-toggle="modal" data-bs-target="#delete_user=<?= $data['id'] ?>" class="btn btn-danger btn-sm">🗑️</button>
                                    </th>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>

            <div class="contents" id="content_shop_type">
                <div class="card border-0 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="m-0">ประเภทร้าน</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="w-100 h-100">
                                    <a class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#add_type_shop">เพิ่มเลย</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table text-center" id="userTable">
                            <thead>
                                <tr>
                                    <th>ชื่อ</th>
                                    <th>gone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($all_shop_type as $data): ?>
                                <tr">
                                    <td><?= $data['name']?> </td>
                                    <th>
                                        <button data-bs-toggle="modal" data-bs-target="#delete_shop_type=<?= $data['id'] ?>" class="btn btn-danger btn-sm">🗑️</button>
                                    </th>
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

<div class="modal fade" id="add_type_shop">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3>เพิ่มข้อมูลประเภทร้านอาหาร</h3>
                <button class="btn-close" data-bs-dismiss="modal" aria-lable="close"></button>
            </div>

            <div class="modal-body">
                <form action="class/handle.php" method="post">
                    <div class="form-floating mb-2">
                        <input type="text" name="name" class="form-control" placeholder="s">
                        <label for="">ชื่อประเภทร้านอาหาร</label>
                    </div>
                    <button type="submit" name="add_shop_type" class="btn btn-primary mt-2 w-100">เพิ่มข้อมูล</button>
                </form>
            </div>
        </div>
    </div>
</div>