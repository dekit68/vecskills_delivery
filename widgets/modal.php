<div class="modal fade" id="createUser">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-4 p-5 border-bottom-0">
                    <h5 class="fs-5">เพิ่มข้อมูลผู้ใช้งาน</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                <form action="core/auth.php?type=reg" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" name="email" placeholder="s" class="form-control" required>
                        <label>Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="password" placeholder="s" class="form-control" required>
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
                                <input type="text" name="fname" placeholder="s" class="form-control" required>
                                <label>fname</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="lname" placeholder="s" class="form-control" required>
                                <label>lname</label>
                            </div>
                        </div>
                    </div>
            

                    <div class="form-floating mb-3">
                        <input type="text" name="address" placeholder="s" class="form-control" required>
                        <label>address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="phone" placeholder="s" class="form-control" required>
                        <label>phone</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 ">
                        ยืนยันการเพิ่มข้อมูล
                    </button>
                </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="createshoptype">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-4 p-5 border-bottom-0">
                    <h5 class="fs-5">เพิ่มข้อมูลประเภทร้านอาหาร</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                <form action="core/shop.php?type=addtype" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" name="name" placeholder="s" class="form-control" required>
                        <label>ประเภทร้านอาหาร</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        ยืนยัน
                    </button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createfoodtype">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-4 p-5 border-bottom-0">
                    <h5 class="fs-5">เพิ่มข้อมูลประเภทอาหาร</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                <form action="core/food.php?type=addtype" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" name="name" placeholder="s" class="form-control" required>
                        <label>ประเภทอาหาร</label>
                    </div>

                    <input type="hidden" name="id" value="<?= $hash['id'] ?>">

                    <button type="submit" class="btn btn-primary w-100">
                        ยืนยัน
                    </button>
                </form>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="createFood">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-4 p-5 border-bottom-0">
                    <h5 class="fs-5">เพิ่มรายการอาหาร</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                <form action="core/food.php?type=add" method="post" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <input type="text" name="name" placeholder="s" class="form-control" required>
                        <label>ชื่อ</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="type" class="form-control">
                            <?php foreach ($food_type as $data) : ?>
                            <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <label>ประเภทอาหาร</label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="number" name="price" placeholder="s" class="form-control" required>
                                <label>ราคา</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="number" name="discount" placeholder="s" class="form-control" required>
                                <label>ส่วนลด</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?= $hash['id'] ?>">

                    <input type="file" name="food_img" class="form-control mb-3">
                
                    <button type="submit" class="btn btn-primary w-100">
                        ยืนยัน
                    </button>
                </form>
                </div>
            </div>
        </div>
    </div>