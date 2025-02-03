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
                <?php if(isset($_SESSION['user_login'])) { ?>
                <li class="dropdown nav-item">
                    <a href="" class="dropdown-toggle nav-link" data-bs-toggle="dropdown"><?= $useAuth['user']['fname']." ". $useAuth['user']['lname']; ?></a>
                    <ul class="dropdown-menu">
                        <li><a href="" class="dropdown-item nav-content" data-content="profile">โปรไฟล์</a></li>
                        <li><a href="class/handle.php?logout" class="dropdown-item text-danger">ออกจากระบบ</a></li>
                    </ul>
                </li>
                <?php } else { ?> 
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#login">Login</button>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<?php if(isset($_SESSION['user_login'])) { ?>
<div class="nav-scroller">
    <nav class="nav">
        <?php if ($_SESSION['role'] === "admin") { ?>
        <a href="" class="nav-link nav-content" data-content="user">จัดการผู้ใช้งาน</a>
        <a href="" class="nav-link nav-content" data-content="delivery">จัดการผู้ส่งอาหาร</a>
        <a href="" class="nav-link nav-content" data-content="manager">จัดการผู้ดูแลร้านอาหาร</a>
        <a href="" class="nav-link nav-content" data-content="shop">จัดการร้านอาหาร</a>
        <a href="" class="nav-link nav-content" data-content="shoptype">จัดการประเภทร้านอาหาร</a>
        <?php } elseif ($_SESSION['role'] === "manager") { ?>
        <?php if ($useAuth['hashshop']) { ?>
        <a href="" class="nav-link nav-content" data-content="access">ขอเปิดร้านอาหาร</a>
        <?php } elseif (isset($useAuth['shop']) && $useAuth['shop']['approve'] == 0) { ?>
        <a href="" class="nav-link nav-content" data-content="access">รออนุมัติจากแอดมิน</a>
        <?php } else {?>
        <a href="" class="nav-link nav-content" data-content="manage">จัดการเมนูอาหาร</a>
        <a href="" class="nav-link nav-content" data-content="type">จัดการประเภทอาหาร</a>
        <a href="" class="nav-link nav-content" data-content="paymented">สรุปยอด</a>
        <?php } ?>
        <?php } elseif ($_SESSION['role'] === "delivery") { ?>
        <a href="" class="nav-link nav-content" data-content="menus">รับรายการอาหาร</a>
        <a href="" class="nav-link nav-content" data-content="confirmfood">ยืนยันรายการอาหาร</a>
        <?php } else { ?>
        <a href="" class="nav-link nav-content" data-content="shoptype">รายการอาหาร</a>
        <a href="" class="nav-link nav-content" data-content="cart">ตะกล้า
            <?php if($totalQty) { ?>
            <span class="badge bg-light text-danger"><?= $totalQty ?></span>
            <?php } ?>
        </a>
        <a href="" class="nav-link nav-content" data-content="oldlist">ประวัติการสั่งซื้อ</a>
        <?php } ?>
    </nav>
</div>
<?php } ?>