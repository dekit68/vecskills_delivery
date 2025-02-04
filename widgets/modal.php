<!-- Admin Modal -->
<?php if ($useAuth['user']['role'] == "admin") { ?>
<?php foreach ($shoptype as $delete) { ?>
<div class="modal fade" id="delete_type-<?= $delete['id'] ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-4 border-bottom-0">
                <h5 class="fs-5">ลบ <?= $delete['name'] ?></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body pt-0">
                <button type="submit" class="btn btn-danger w-100">
                    ยืนยัน
                </button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php foreach ($userAll as $edit) { ?>
<div class="modal fade" id="edit-user-<?= $edit['id'] ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-header border-bottom-0">
                <h5 class="fs-5">จัดการผู้ใช้งาน <?= $edit['email'] ?></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>

            <div class="modal-body pt-0">
                <input type="text" name="confirm" id="confirm-input-<?= $edit['id'] ?>" placeholder="พิมพ์ 'confirm' เพื่อยืนยัน" class="form-control mb-3 d-none" required>
                <a href="class/handle.php?active=<?= $edit['id'] ?>" class="btn btn-primary"><?= $edit['status'] ? 'ยกเลิก' : 'อนุมัติ' ?></a>
                <button type="button" class="btn btn-danger" id="delete-btn-<?= $edit['id'] ?>">ลบ</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#delete-btn-<?= $edit['id'] ?>').on('click', function(){
        var confirmInput = $('#confirm-input-<?= $edit['id'] ?>');
        if (confirmInput.hasClass('d-none')) {
            confirmInput.removeClass('d-none').focus();
        } else {
            if (confirmInput.val().trim().toLowerCase() === 'confirm') {
                window.location.href = 'class/handle.php?delete=<?= $edit['id'] ?>';
            } else {
                alert("กรุณาพิมพ์ 'confirm' ให้ถูกต้องเพื่อยืนยันการลบ");
            }
        }
    });
});
</script>
<?php } ?>

<div class="modal fade" id="create-type-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-header border-bottom-0">
                <h5 class="fs-5">เพิ่มข้อมูลประเภทร้านอาหาร</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>

            <div class="modal-body pt-0">
                <form action="core/user.php?type=updatebyadmin" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" name="email" placeholder="s"class="form-control" required>
                        <label>ชื่อ</label>
                    </div>
                    <button type="submit" name="" class="btn btn-primary w-100">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<!-- Users Modal -->