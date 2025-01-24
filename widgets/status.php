<?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error'] ?>
    </div>
<?php unset($_SESSION['error']); } ?>

<?php if (isset($_SESSION['success'])) { ?>
    <div class="alert alert-success">
        <?= $_SESSION['success'] ?>
    </div>
<?php unset($_SESSION['success']); } ?>