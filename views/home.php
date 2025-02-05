
    <div class="modal fade" id="login">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-4 p-5 border-bottom-0">
                    <h5 class="fs-5">ลงทะเบียนเข้าสู่ระบบ</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                    <form action="class/handle.php" method="post">
                        <div class="form-floating mb-2">
                            <input type="email" name="email" class="form-control" placeholder="s">
                            <label for="">Email</label>
                        </div>
                        
                        <div class="form-floating mb-2">
                            <input type="password" name="password" class="form-control" placeholder="s">
                            <label for="">Password</label>
                        </div>

                        <button type="submit" name="signin" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#register">สมัครสมาชิก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="register">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-4 p-5 border-bottom-0">
                    <h5 class="fs-5">ลงทะเบียนสมัครสมาชิก</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                <form action="class/handle.php" method="post">
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

                    <button type="submit" name="signup" class="btn btn-primary w-100">
                        ลงทะเบียนสมัครสมาชิก
                    </button>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#login">สมัครสมาชิก</button>
                </div>
                </div>
            </div>
        </div>
    </div>