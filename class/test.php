<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<?php

require '../db.php';
$db = new Database();
$pdo = $db->getConnect(); 

session_start();

if (isset($_SESSION['error'])) {
    echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo '<p style="color: green;">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['user_login'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_login']]);
    $user = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT * FROM shop WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_login']]);
    $hash = $stmt->fetch();
}

?>

<h1>Login</h1>
<form action="users.php?controller=Users&method=login" method="post" class="mb-4">
    <div class="form-group">
        <label for="email_login">Email:</label>
        <input type="email" id="email_login" name="email" class="form-control" required placeholder="Enter your email">
    </div>

    <div class="form-group">
        <label for="password_login">Password:</label>
        <input type="password" id="password_login" name="password" class="form-control" required placeholder="Enter your password">
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
</form>

<h1>Register</h1>
<form action="users.php?controller=Users&method=register" method="post" class="mb-4">
    <div class="form-group">
        <label for="email_register">Email:</label>
        <input type="email" id="email_register" name="email" class="form-control" required placeholder="Enter your email">
    </div>

    <div class="form-group">
        <label for="password_register">Password:</label>
        <input type="password" id="password_register" name="password" class="form-control" required placeholder="Enter your password">
    </div>

    <div class="form-group">
        <label for="role">Role:</label>
        <select name="role" id="role" class="form-control" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <div class="form-group">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" class="form-control" required placeholder="First Name">
    </div>

    <div class="form-group">
        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" class="form-control" required placeholder="Last Name">
    </div>

    <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" class="form-control" required placeholder="Address">
    </div>

    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" class="form-control" required placeholder="Phone Number">
    </div>

    <button type="submit" class="btn btn-success">Register</button>
</form>
<h1>update</h1>

<form action="users.php?controller=Users&method=update" method="post" enctype="multipart/form-data">
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

