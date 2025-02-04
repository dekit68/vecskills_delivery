<?php
    // Data Table
    $user = $table_user->getWhere("role = ?", ['user']);
    $delivery = $table_user->getWhere("role = ?", ['delivery']);
    $manager = $table_user->getWhere("role = ?", ['manager']);
    $shop = $table_shop->getAll();
    $shoptype = $table_shop_type->getAll();
    $userAll = $table_user->getAll();
    $shoptypehead = ['name'];
    $shoptypebody = ['name'];
    $userhead = ['ID', 'ชื่อ', 'อีเมล', 'เบอร์โทร', 'ที่อยู่', 'สถานะ'];
    $userbody = ['id', 'fname lname', 'email', 'phone', 'address','status'];

    // Components or Widgets
    include 'widgets/navbar.php'; 
    include 'widgets/modal.php';
?>

<div class="container my-5">
    <?php include 'widgets/status.php'; ?>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="contents" id="user">
                <div class="d-flex justify-content-between mb-2"><h4 class="fs-5">จัดการผู้ใช้งาน</h4></div>
                <?php $ui->table($userhead, $userbody, $user, 'edit-user'); ?>
            </div>
            <div class="contents" id="manager"><div class="d-flex justify-content-between mb-2"><h4 class="fs-5">จัดการผู้ดูแลร้านอาหาร</h4></div>
                <?php $ui->table($userhead, $userbody, $manager, 'edit-user'); ?>
            </div>
            <div class="contents" id="delivery"><div class="d-flex justify-content-between mb-2"><h4 class="fs-5">จัดการผู้ส่งอาหาร</h4></div>
                <?php $ui->table($userhead, $userbody, $delivery, 'edit-user'); ?>
            </div>
            <div class="contents" id="shop"><div class="d-flex justify-content-between mb-2"><h4 class="fs-5">จัดการร้านอาหาร</h4></div>
                <?php $ui->table($userhead, $userbody, $shop, 'edit-user'); ?>
            </div>
            <div class="contents" id="shoptype">
                <div class="d-flex justify-content-between mb-2">
                    <h4 class="fs-5">จัดการประเภทร้านอาหาร</h4>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#create-type-1">เพิ่มข้อมูลประเภทร้านอาหาร</button>
                </div>
                <?php $ui->table($shoptypehead, $shoptypebody, $shoptype, 'delete_type'); ?>
            </div>
        </div>
    </div>
    <?php include 'widgets/profile.php' ?>
</div>