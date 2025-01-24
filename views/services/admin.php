<?php
    $stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'user' ");
    $stmt->execute();
    $users = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'delivery' ");
    $stmt->execute();
    $deliverys = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'manager' ");
    $stmt->execute();
    $managers = $stmt->fetchAll();


    $stmt = $pdo->prepare("SELECT * FROM shop");
    $stmt->execute();
    $shops = $stmt->fetchAll();

    
    $stmt = $pdo->prepare("SELECT * FROM shop_type");
    $stmt->execute();
    $shoptype = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <?php 
        include 'widgets/navbar.php'; 
        include 'widgets/modal.php';
    ?>

    <div class="container my-5">
        <?php include 'widgets/status.php'; ?>
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="contents" id="user">
                    <div class="d-flex justify-content-between mb-2">
                        <h4 class="fs-5">จัดการผู้ใช้งาน</h4>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createUser">เพิ่มข้อมูลผู้ใช้งาน</button>
                    </div>

                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>ที่อยู่</th>
                                <th>เบอร์โทร</th>
                                <th>อีเมล์</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['fname'] ?></td>
                                <td><?= $user['lname'] ?></td>
                                <td><?= $user['address'] ?></td>
                                <td><?= $user['phone'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td>
                                    <form action="core/user.php?type=access" method="post" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button class="btn btn-primary">
                                            <?php echo ($user['status'] == 1) ? 'ยกเลิก' : 'ระงับผู้ใช้งานชั่วคราว'; ?>
                                        </button>
                                    </form>

                                    <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#edit-<?= $user['id'] ?>">แก้ไข</button>

                                    <form action="core/user.php?type=delete" method="post" onsubmit="return confirm('คุณต้องการลบหรือไม่')" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button class="btn btn-outline-danger">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="edit-<?= $user['id'] ?>">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header pb-4 p-5 border-bottom-0">
                                            <h5 class="fs-5">เพิ่มข้อมูลผู้ใช้งาน</h5>
                                            <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                        </div>

                                        <div class="modal-body p-5 pt-0">
                                        <form action="core/user.php?type=updatebyadmin" method="post">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="email" value="<?= $user['email'] ?>" placeholder="s" class="form-control" required>
                                                <label>Email</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" name="password" value="<?= $user['password'] ?>" placeholder="s" class="form-control" required>
                                                <label>Password</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select name="role" class="form-control" required>
                                                    <option value="user">User</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="manager">Manager</option>
                                                    <option value="delivery">Delivery</option>
                                                </select>
                                                <label>Role</label>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="fname" value="<?= $user['fname'] ?>" placeholder="s" class="form-control" required>
                                                        <label>fname</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="lname" value="<?= $user['lname'] ?>" placeholder="s" class="form-control" required>
                                                        <label>lname</label>
                                                    </div>
                                                </div>
                                            </div>
                                    

                                            <div class="form-floating mb-3">
                                                <input type="text" name="address" value="<?= $user['address'] ?>" placeholder="s" class="form-control" required>
                                                <label>address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" name="phone" value="<?= $user['phone'] ?>" placeholder="s" class="form-control" required>
                                                <label>phone</label>
                                            </div>
                                             <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <button type="submit" class="btn btn-primary w-100 ">
                                                ยืนยันการเพิ่มข้อมูล
                                            </button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>


            <div class="col-md-12">

                <div class="contents" id="manager">
                    <div class="d-flex justify-content-between mb-2">
                        <h4 class="fs-5">จัดการผู้ดูแลร้านอาหาร</h4>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createUser">เพิ่มข้อมูลผู้ใช้งาน</button>
                    </div>

                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>ที่อยู่</th>
                                <th>เบอร์โทร</th>
                                <th>อีเมล์</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($managers as $manager): ?>
                            <tr>
                                <td><?= $manager['id'] ?></td>
                                <td><?= $manager['fname'] ?></td>
                                <td><?= $manager['lname'] ?></td>
                                <td><?= $manager['address'] ?></td>
                                <td><?= $manager['phone'] ?></td>
                                <td><?= $manager['email'] ?></td>
                                <td>
                                    <form action="core/user.php?type=access" method="post" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $manager['id'] ?>">
                                        <button class="btn btn-primary">
                                            <?php echo ($manager['status'] == 1) ? 'ยกเลิก' : 'อนุมัติ'; ?>
                                        </button>
                                    </form>

                                    <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#edit-<?= $manager['id'] ?>">แก้ไข</button>

                                    <form action="core/user.php?type=delete" method="post" onsubmit="return confirm('คุณต้องการลบหรือไม่')" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $manager['id'] ?>">
                                        <button class="btn btn-outline-danger">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="edit-<?= $manager['id'] ?>">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header pb-4 p-5 border-bottom-0">
                                            <h5 class="fs-5">เพิ่มข้อมูลผู้ใช้งาน</h5>
                                            <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                        </div>

                                        <div class="modal-body p-5 pt-0">
                                        <form action="core/user.php?type=updatebyadmin" method="post">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="email" value="<?= $manager['email'] ?>" placeholder="s" class="form-control" required>
                                                <label>Email</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" name="password" value="<?= $manager['password'] ?>" placeholder="s" class="form-control" required>
                                                <label>Password</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select name="role" class="form-control" required>
                                                    <option value="user">User</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="manager">Manager</option>
                                                    <option value="delivery">Delivery</option>
                                                </select>
                                                <label>Role</label>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="fname" value="<?= $manager['fname'] ?>" placeholder="s" class="form-control" required>
                                                        <label>fname</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="lname" value="<?= $manager['lname'] ?>" placeholder="s" class="form-control" required>
                                                        <label>lname</label>
                                                    </div>
                                                </div>
                                            </div>
                                    

                                            <div class="form-floating mb-3">
                                                <input type="text" name="address" value="<?= $manager['address'] ?>" placeholder="s" class="form-control" required>
                                                <label>address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" name="phone" value="<?= $manager['phone'] ?>" placeholder="s" class="form-control" required>
                                                <label>phone</label>
                                            </div>
                                             <input type="hidden" name="id" value="<?= $manager['id'] ?>">
                                            <button type="submit" class="btn btn-primary w-100 ">
                                                ยืนยันการเพิ่มข้อมูล
                                            </button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>



                <div class="contents" id="delivery">
                    <div class="d-flex justify-content-between mb-2">
                        <h4 class="fs-5">จัดการผู้ส่งอาหาร</h4>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createUser">เพิ่มข้อมูลผู้ใช้งาน</button>
                    </div>

                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>ที่อยู่</th>
                                <th>เบอร์โทร</th>
                                <th>อีเมล์</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($deliverys as $delivery): ?>
                            <tr>
                                <td><?= $delivery['id'] ?></td>
                                <td><?= $delivery['fname'] ?></td>
                                <td><?= $delivery['lname'] ?></td>
                                <td><?= $delivery['address'] ?></td>
                                <td><?= $delivery['phone'] ?></td>
                                <td><?= $delivery['email'] ?></td>
                                <td>
                                <form action="core/user.php?type=access" method="post" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $delivery['id'] ?>">
                                        <button class="btn btn-primary">
                                            <?php echo ($delivery['status'] == 1) ? 'ยกเลิก' : 'อนุญาต'; ?>
                                        </button>
                                    </form>

                                    <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#edit-<?= $delivery['id'] ?>">แก้ไข</button>


                                    <form action="core/user.php?type=delete" method="post" onsubmit="return confirm('คุณต้องการลบหรือไม่')" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $delivery['id'] ?>">
                                        <button class="btn btn-outline-danger">ลบ</button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="edit-<?= $delivery['id'] ?>">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header pb-4 p-5 border-bottom-0">
                                            <h5 class="fs-5">เพิ่มข้อมูลผู้ใช้งาน</h5>
                                            <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                        </div>

                                        <div class="modal-body p-5 pt-0">
                                        <form action="core/user.php?type=updatebyadmin" method="post">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="email" value="<?= $delivery['email'] ?>" placeholder="s" class="form-control" required>
                                                <label>Email</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" name="password" value="<?= $delivery['password'] ?>" placeholder="s" class="form-control" required>
                                                <label>Password</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select name="role" class="form-control" required>
                                                    <option value="user">User</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="manager">Manager</option>
                                                    <option value="delivery">Delivery</option>
                                                </select>
                                                <label>Role</label>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="fname" value="<?= $delivery['fname'] ?>" placeholder="s" class="form-control" required>
                                                        <label>fname</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="lname" value="<?= $delivery['lname'] ?>" placeholder="s" class="form-control" required>
                                                        <label>lname</label>
                                                    </div>
                                                </div>
                                            </div>
                                    

                                            <div class="form-floating mb-3">
                                                <input type="text" name="address" value="<?= $delivery['address'] ?>" placeholder="s" class="form-control" required>
                                                <label>address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" name="phone" value="<?= $delivery['phone'] ?>" placeholder="s" class="form-control" required>
                                                <label>phone</label>
                                            </div>
                                             <input type="hidden" name="id" value="<?= $delivery['id'] ?>">
                                            <button type="submit" class="btn btn-primary w-100 ">
                                                ยืนยันการเพิ่มข้อมูล
                                            </button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
                


                <div class="contents" id="shop">
                    <div class="d-flex justify-content-between mb-2">
                        <h4 class="fs-5">จัดการร้านอาหาร</h4>
                    </div>

                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อร้านอาหาร</th>
                                <th>ที่อยู่</th>
                                <th>เบอร์โทร</th>
                                <th>สถานะ</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($shops as $shop): ?>
                            <tr>
                                <td><?= $shop['id'] ?></td>
                                <td><?= $shop['name'] ?></td>
                                <td><?= $shop['address'] ?></td>
                                <td><?= $shop['phone'] ?></td>
                                <td class="text-<?php echo($shop['approve'] == 1) ? 'success' : 'danger'; ?>"><?php echo($shop['approve'] == 1) ? 'อนุญาตแล้ว' : 'ยังไม่อนุญาต' ?></td>
                                <td>
                                    <form action="core/shop.php?type=access" method="post" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $shop['id'] ?>">
                                        <button class="btn btn-primary">
                                            <?php echo ($shop['approve'] == 1) ? 'ยกเลิก' : 'อนุมัติร้านอาหาร'; ?>
                                        </button>
                                </form>
                                </td>
                            </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>


                <div class="contents" id="shoptype">
                    <div class="d-flex justify-content-between mb-2">
                        <h4 class="fs-5">จัดการประเภทร้านอาหาร</h4>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createshoptype">เพิ่มข้อมูลประเภทร้านอาหาร</button>
                    </div>

                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อประเภทร้านอาหาร</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($shoptype as $shoptypes): ?>
                            <tr>
                                <td><?= $shoptypes['id'] ?></td>
                                <td><?= $shoptypes['name'] ?></td>
                                <td>
                                    <form action="core/shop.php?type=deletetype" onsubmit="return confirm('คุณต้องการลบหรือไม่')" method="post" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $shoptypes['id'] ?>">
                                        <button class="btn btn-outline-danger">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

    <?php include 'widgets/profile.php' ?>
</body>
</html>