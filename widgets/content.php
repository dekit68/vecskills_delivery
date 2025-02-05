
    <div class="contents" id="profile">
        <form action="class/handle.php" method="post" enctype="multipart/form-data" class="p-4 rounded">
            <div class="text-center mb-4">
                <img data-bs-toggle="modal" data-bs-target="#image_upload" src="<?= $useAuth['user']['image'] ? $useAuth['user']['image'] : '/views/assets/img/none.png' ?>" alt="Profile Picture" class="rounded-circle" style="width: 300px; height: 300px; object-fit: cover;">
            </div>
            <!-- First Name and Last Name -->
            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" name="fname" placeholder="First Name"
                            value="<?= $useAuth['user']['fname'] ?>" class="form-control" required>
                        <label for="fname">First Name</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" name="lname" placeholder="Last Name" value="<?= $useAuth['user']['lname'] ?>"
                            class="form-control" required>
                        <label for="lname">Last Name</label>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email" name="email" placeholder="Email" value="<?= $useAuth['user']['email'] ?>"
                    class="form-control" required>
                <label for="email">Email</label>
            </div>

            <!-- Address -->
            <div class="form-floating mb-3">
                <input type="text" name="address" placeholder="Address" value="<?= $useAuth['user']['address'] ?>"
                    class="form-control" required>
                <label for="address">Address</label>
            </div>

            <!-- Phone -->
            <div class="form-floating mb-3">
                <input type="text" name="phone" placeholder="Phone" value="<?= $useAuth['user']['phone'] ?>"
                    class="form-control" required>
                <label for="phone">Phone</label>
            </div>

            <!-- Image -->
            <div class="modal fade" id="image_upload">
                <div class="modal-dialog modal-dialog-centered p-4 py-md-5">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-header border-bottom-0">
                            <h1 class="modal-title fs-5" id="confirm_changeLabel">เลือกรูป</h1>
                            <button type="button" class="btn-close" onclick="window.location.reload();"></button>
                        </div>
                        <div class="modal-body py-0">
                            <input name="image" class="form-control" multiple type="file">
                        </div>
                        <div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
                            <button type="button" class="btn btn-lg btn-primary" data-bs-dismiss="modal">เลือก</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirm -->
            <div class="modal fade" id="confirm_change">
                <div class="modal-dialog modal-dialog-centered p-4 py-md-5">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-header border-bottom-0">
                            <h1 class="modal-title fs-5" id="confirm_changeLabel">แก้ไขโปรไฟล์</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-0">
                            <p>กด ยืนยันเพื่อแก้ไขข้อมูลของท่านได้เลย ค้าบบบบ 🎯</p>
                        </div>
                        <div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
                            <button type="submit" name="update_profile" class="btn btn-lg btn-primary">ยืนยัน</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div class="d-flex justify-content-center mb-3">
                <a data-bs-toggle="modal" data-bs-target="#change"
                    class="btn btn-primary w-100 btn-lg">เปลี่ยนรหัสผ่าน</a>
            </div>

            <div class="d-flex justify-content-center">
                <a data-bs-toggle="modal" data-bs-target="#confirm_change"
                    class="btn btn-primary w-100 btn-lg">บันทึก</a>
            </div>
        </form>
    </div>


<!-- Change Password -->
<div class="modal fade" id="change">
    <div class="modal-dialog modal-dialog-centered p-4 py-md-5">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-bottom-0">
                <h1 class="modal-title fs-5" id="confirm_changeLabel">เปลี่ยนรหัสผ่าน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="class/handle.php" method="post" class="mb-0">
                <div class="modal-body py-0">
                    <div class="form-floating mb-3">
                        <input type="password" name="OP" placeholder="Email" class="form-control" required>
                        <label>รหัสเก่า</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" name="NP" placeholder="Address" class="form-control" required>
                        <label>รหัสใหม่</label>
                    </div>
                </div>
                <div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
                    <button type="submit" name="update_password" class="btn btn-lg btn-primary">ยืนยัน</button>
                </div>
            </form>
        </div>
    </div>
</div>