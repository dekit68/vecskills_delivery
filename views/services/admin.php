<?php
    // Data Table
    $shop = $dataHandler->get("SELECT * FROM shop");
    $shoptype = $dataHandler->get("SELECT * FROM shop_type");
    $userAll = $dataHandler->get("SELECT * FROM users");
    $shoptypehead = ['name'];
    $shoptypebody = ['name'];
    $userhead = ['ID', 'ชื่อ', 'อีเมล', 'เบอร์โทร', 'ที่อยู่', 'สถานะ'];
    $userbody = ['id', 'fname lname', 'email', 'phone', 'address','status'];
    include 'widgets/modal.php';
?>

<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-12">
            <div class="contents" id="user">
                <h1>user</h1>
                <!-- Table Section -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <?php $interface->table($userhead, $userbody, $userAll, 'edit-user'); ?>
                    </div>
                </div>
            </div>

            <div class="contents" id="manager">
                <h1>manager</h1>
                <!-- Table Section -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <?php $interface->table($userhead, $userbody, $userAll, 'edit-user'); ?>
                    </div>
                </div>
            </div>

            <div class="contents" id="delivery">
                <h1>delivery</h1>
                <!-- Table Section -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <?php $interface->table($userhead, $userbody, $userAll, 'edit-user'); ?>
                    </div>
                </div>
            </div>
            <div class="contents" id="shop">
                <div class="d-flex justify-content-between mb-2">
                    <h4 class="fs-5">จัดการร้านอาหาร</h4>
                </div>
                <?php $interface->table($userhead, $userbody, $shop, 'edit-user'); ?>
            </div>
            <div class="contents" id="shoptype">
                <div class="d-flex justify-content-between mb-2">
                    <h4 class="fs-5">จัดการประเภทร้านอาหาร</h4>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#create-type-1">เพิ่มประเภทร้านอาหาร</button>
                </div>
                <?php $interface->table($shoptypehead, $shoptypebody, $shoptype, 'delete_type'); ?>
            </div>

            <?php include 'widgets/content.php' ?>
        </div>
    </div>
</div>