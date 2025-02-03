<?php 

$all = 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
</head>

<body>
    <?php include 'widgets/navbar.php'; ?>
    <?php include 'widgets/modal.php'; ?>
    <div class="container py-5">        
        <?php include 'widgets/status.php'; ?>
        <?php if($useAuth['hashshop']) { ?>
        <div class="contents" id="access">
            <h1>คำขอเปิดร้าน 🍕</h1>
            <hr>
            <form action="core/shop.php?type=get" method="post">
                <div class="form-floating mb-3">
                    <input type="text" name="name" placeholder="s" class="form-control" required>
                    <label>ชื่อร้าน</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="type" class="form-control">
                        <?php foreach ($shop_type as $data) : ?>
                        <option value="<?= $data['id'] ?>">
                            <?= $data['name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <label>ประเภทร้านอาหาร</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="address" placeholder="s" class="form-control" required>
                    <label>ที่อยู่</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="phone" placeholder="s" class="form-control" required>
                    <label>เบอร์โทร</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg">ร้องขอเปิดร้าน</button>
            </form>
        </div>

        <?php } elseif (isset($useAuth['shop']) && $useAuth['shop']['approve'] == 0) { ?>
        <div class="contents" id="access">
            <div class="alert alert-success">
                คำขอของคุณได้ถูกส่งไปแล้วรอการอนุมัติจากแอดมินสักครู่ 😉
            </div>
            <form action="core/shop.php?type=update" method="post">
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control" value="<?= $hash['name'] ?>" required
                        placeholder="s">
                    <label>ชื่อร้าน</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="type" class="form-control">
                        <?php foreach ($shop_type as $data) : ?>
                        <option value="<?= $data['id'] ?>">
                            <?= $data['name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <label>ประเภทร้านอาหาร</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="address" class="form-control" value="<?= $hash['address'] ?>" required
                        placeholder="s">
                    <label>ที่อยู่</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="phone" class="form-control" value="<?= $hash['phone'] ?>" required
                        placeholder="s">
                    <label>เบอร์โทร</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-lg">อัพเดท</button>
            </form>
        </div>
        <?php } else { ?>
        <div class="contents" id="manage">
            <div class="d-flex justify-content-between mb-2">
                <h1>จัดการเมนูอาหาร</h1>
                <button class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#createFood">เพิ่มรายการอาหาร</button>
            </div>
            <hr>
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="" class="form-select" id="filterfood">
                            <option value="">ทั้งหมด</option>
                            <?php foreach($food_type as $food_types):  ?>
                            <option value="<?= $food_types['id'] ?>">
                                <?= $food_types['name'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="">เลือกประเภทอาหาร</label>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="" class="form-select" id="filtershop" disabled>
                            <option value=""><?= $hash['name'] ?></option>
                        </select>
                        <label for="">ร้านอาหาร</label>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" placeholder="s" class="form-control" id="serach">
                        <label for="">เลือกประเภทอาหาร</label>
                    </div>
                </div>

                <?php foreach($listFood as $data): ?>
                <div class="col-md-4 mt-4 food-item" data-foodtype="<?= $data['type_id'] ?>" data-shopname="<?= $data['shop_id'] ?>">
                    <div class="card">
                        <div class="d-flex justify-content-center">
                            <img src="<?= $data['food_img'] ?>" alt="" class="card-img-top"
                                style="width: auto;  height: 200px;">
                        </div>


                        <div class="card-body">
                            <h5 class="card-title">
                                <?= $data['name'] ?>
                            </h5>
                            <p class="card-text text-secondary">
                                <?= $data['foodtype'] ?> |
                                <?= $data['shopname'] ?>
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editfood-<?= $data['id'] ?>">แก้ไข</button>
                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deletefood-<?= $data['id'] ?>">ลบ</button>
                                </div>

                                <small class="text-success fw-bold">
                                    <?= $data['price'] ?>บาท
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editfood-<?= $data['id'] ?>">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header pb-4 p-5 border-bottom-0">
                                <h5 class="fs-5">เพิ่มรายการอาหาร</h5>
                                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                            </div>

                            <div class="modal-body p-5 pt-0">
                                <form action="core/food.php?type=update" method="post"
                                    enctype="multipart/form-data">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name" placeholder="s" value="<?= $data['name'] ?>"
                                            class="form-control" required>
                                        <label>ชื่อ</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select name="type" class="form-control">
                                            <?php foreach ($food_type as $data1) : ?>
                                            <option value="<?= $data1['id'] ?>"><?= $data1['name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <label>ประเภทอาหาร</label>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="number" name="price" placeholder="s"
                                                    value="<?= $data['price'] ?>" class="form-control" required>
                                                <label>ราคา</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="number" name="discount" value="<?= $data['discount'] ?>"
                                                    placeholder="s" class="form-control" required>
                                                <label>ส่วนลด</label>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">

                                    <input type="file" name="food_img" class="form-control mb-3">

                                    <button type="submit" class="btn btn-primary w-100">
                                        ยืนยัน
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deletefood-<?= $data['id'] ?>">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>ยืนยันลบ</h5>
                                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="core/food.php?type=delete" method="post">
                                    <div class="list-group">
                                        <div
                                            class="list-group-item d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h6><?= $data['name'] ?></h6>
                                                <small class="text-secondary">ประเภทอาหาร |
                                                    <?= $data['foodtype'] ?></small>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">

                                    <button type="submit" class="btn btn-danger btn-lg w-100">
                                        ลบเลย
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>

            </div>
        </div>

        <div class="contents" id="type">
            <div class="d-flex justify-content-between mb-2">
                <h4 class="fs-5">จัดการประเภทอาหาร</h4>
                <button class="btn btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#createfoodtype">เพิ่มข้อมูลประเภทอาหาร</button>
            </div>

            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อประเภทอาหาร</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($food_type as $data): ?>
                    <tr>
                        <td>
                            <?= $data['id'] ?>
                        </td>
                        <td>
                            <?= $data['name'] ?>
                        </td>
                        <td>
                            <form action="core/food.php?type=deletetype" method="post"
                                style="display: inline;" onsubmit="return confirm('ลบเลยนะ');">
                                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                <button class="btn btn-outline-danger">ลบ</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach;  ?>
                </tbody>
            </table>
        </div>


        <div class="contents" id="paymented">
            <div class="d-flex justify-content-between mb-2">
                <h4 class="fs-5">สรุปยอด วัน/เดือน/ปี</h4>
            </div>

            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>วันที่ / เวลา</th>
                        <th>รายรับ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($orders as $data): 
                        $stmt = $pdo->prepare("SELECT order_detail.*, food.name AS food_name, food.food_img AS food_imgs FROM order_detail JOIN food ON order_detail.food_id = food.id WHERE order_detail.id = ?");
                        $stmt ->execute([$data['id']]);
                        $odd = $stmt->fetchAll();
                        $total = 0;
                        foreach($odd as $datas):
                           $con = $datas['price'] * $datas['qty'];
                           $total += $con;
                  
                        endforeach;
                        $all += $total;
                    ?>
                    <tr>
                        <td><?= $data['date'] ?></td>
                        <td><?= number_format($total, 2) ?></td>
                        <td><a href="bill.php?id=<?= $data['id'] ?>" class="btn btn-outline-danger">พิมพ์ใบเสร็จ</a></td>
                    </tr>
                    <?php endforeach;  ?>
                </tbody>
            </table>
            <th>รวมทั้งหมด <?= number_format($all,2) ?> ฿</th>
        </div>

        <?php } ?>

        <?php include 'widgets/profile.php'; ?>


    </div>
    </div>



</body>

</html>