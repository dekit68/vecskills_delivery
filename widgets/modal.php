<!-- Admin Modal -->
<?php if (isset($useAuth['user']) && $useAuth['user']['role'] == "admin") { ?>
<?php 

foreach ($shoptype as $data) {
    $interface->ConA('ลบเลยนะ', 'กดยืนยันเพื่อลบ '.$data['name'].' 🎯', 'danger', 'delete_type='.$data["id"].'');
}

?>
<?php foreach ($userAll as $edit): ?>
<div class="modal fade" id="edit-user=<?= $edit['id'] ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-header border-bottom-0">
                <h5 class="fs-5">จัดการผู้ใช้งาน <?= $edit['email'] ?></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="input-group mb-3">
                    <input type="text" name="confirm" id="confirm-input-<?= $edit['id'] ?>" placeholder="พิมพ์ 'confirm' เพื่อลบ" class="form-control" required>
                    <button type="button" class="btn btn-danger" id="delete-btn-<?= $edit['id'] ?>">ลบ</button>
                </div>       
                <a href="class/handle.php?active=<?= $edit['id'] ?>" class="btn btn-primary w-100"><?= $edit['status'] ? 'ยกเลิก' : 'อนุมัติ' ?></a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#delete-btn-<?= $edit['id'] ?>').on('click', function(){
        var confirmInput = $('#confirm-input-<?= $edit['id'] ?>');
        if (confirmInput.val().trim().toLowerCase() === 'confirm') {
            window.location.href = 'class/handle.php?delete=<?= $edit['id'] ?>';
        } else {
            alert("กรุณาพิมพ์ 'confirm' ให้ถูกต้องเพื่อยืนยันการลบ");
        }
    });
});
</script>
<?php endforeach; ?>

<div class="modal fade" id="create-type-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-header border-bottom-0">
                <h5 class="fs-5">เพิ่มข้อมูลประเภทร้านอาหาร</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="class/handle.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" name="name" placeholder="s"class="form-control" required>
                        <label>ชื่อ</label>
                    </div>
                    <button type="submit" name="add_shop_type" class="btn btn-primary w-100">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<!-- Users Modal -->
<?php $interface->ConA('ออกจากระบบ', 'กดยืนยันเพื่อออกจากระบบ 🎯', 'danger', 'logout'); ?>