<div class="contents" id="profile">
    <h1>Profile</h1><hr>
    <form action="core/user.php?type=update" method="post" enctype="multipart/form-data">
        <img src="<?= $user['profile_img'] ?>" alt="">
        <div class="form-floating mb-3">
            <input type="text" name="email" placeholder="s" value="<?= $user['email'] ?>" class="form-control" required>
            <label>Email</label>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" name="fname" placeholder="s" value="<?= $user['fname'] ?>" class="form-control" required>
                    <label>fname</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" name="lname" placeholder="s" value="<?= $user['lname'] ?>" class="form-control" required>
                    <label>lname</label>
                </div>
            </div>
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="address" placeholder="s" value="<?= $user['address'] ?>" class="form-control" required>
            <label>address</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="phone" placeholder="s" value="<?= $user['phone'] ?>" class="form-control" required>
            <label>phone</label>
        </div>
    
        <input type="file" name="profile_img" class="form-control mb-3">

        <button type="submit" class="btn btn-primary w-100 btn-lg">
            อัพเดทโปรไฟล์
        </button>
    </form>

    <form action="core/user.php?type=change" method="post" enctype="multipart/form-data">
        
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="password" name="op" placeholder="s" class="form-control" required>
                    <label>Old Password</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="password" name="np" placeholder="s" class="form-control" required>
                    <label>New Password</label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 btn-lg">
            เปลี่ยนรหัสผ่าน
        </button>
    </form>
</div>