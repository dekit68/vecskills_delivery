<nav class="navbar navbar-dark bg-dark navbar-expand-md fixed-top">
    <div class="container">
        <a href="" class="navbar-brand">
            <img src="assets/logo.png" alt=""> ระบบสั่งจองอาหารออนไลน์
        </a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="ms-auto navbar-nav">
                <?php if(isset($useAuth['user'])) { ?>
                    <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                            <?= $useAuth['user']['fname']." ".$useAuth['user']['lname']; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item nav-content" data-content="profile">โปรไฟล์</a></li>
                            <li><button data-bs-toggle="modal" data-bs-target="#logout" class="dropdown-item text-danger">ออกจากระบบ</button></li>
                        </ul>
                    </li>
                <?php } else { ?> 
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#login">Login</button>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<?php if(isset($useAuth['user'])) { $role = $useAuth['user']['role']; ?>
<div class="nav-scroller">
    <nav class="nav">
        <?php if ($role === "admin"): ?>
            <a href="#" class="nav-link nav-content" data-content="user">จัดการผู้ใช้งาน</a>
            <a href="#" class="nav-link nav-content" data-content="manager">จัดการผู้ใช้งาน</a>
            <a href="#" class="nav-link nav-content" data-content="delivery">จัดการผู้ใช้งาน</a>
            <a href="#" class="nav-link nav-content" data-content="shop">จัดการร้านอาหาร</a>
            <a href="#" class="nav-link nav-content" data-content="shoptype">จัดการประเภทร้านอาหาร</a>
        <?php endif; ?>
        <?php if ($role === "manager"): ?>
            <a href="#" class="nav-link nav-content" data-content="main">หน้าหลัก</a>
            <?php if($useAuth['shop'] && $useAuth['shop']['status'] == 1) : ?>
            <a href="#" class="nav-link nav-content" data-content="user">จัดการผู้ใช้งาน</a>
            <a href="#" class="nav-link nav-content" data-content="shop">เมนูอาหาร</a>
            <a href="#" class="nav-link nav-content" data-content="shoptype">ประเภทอาหาร</a>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($role === "delivery"): ?>
            <a href="#" class="nav-link nav-content" data-content="user">รับออเดอร์</a>
            <a href="#" class="nav-link nav-content" data-content="delivery">ยืนยัน</a>
        <?php endif; ?>
        <?php if ($role === "user"): ?>
            <a href="#" class="nav-link nav-content" data-content="user">เมนูอาหาร</a>
            <a href="#" class="nav-link nav-content" data-content="user">ตะกล้า</a>
        <?php endif; ?>
    </nav>
</div>
<?php } ?>