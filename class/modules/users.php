<?php
class Users {
    private $pdo;
    private $table_name = "users";
    public $email;
    public $password;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table_name WHERE email = ?");
        $stmt->execute([$email]);
        $UserEx = $stmt->fetch();
        if ($UserEx) {
            if ($UserEx['status'] == 1) {
                if (password_verify($password, $UserEx['password'])) {
                    $_SESSION['user_login'] = $UserEx['id'];
                    $_SESSION['role'] = $UserEx['role'];
                    $_SESSION['success'] = "เข้าสู่ระบบสำเร็จ";
                    return true;
                } else {
                    $_SESSION['error'] = "รหัสผ่านไม่ถูกต้อง";
                }
            } else {
                $_SESSION['error'] = "รอแอดมินอนุมัติ";
            }
        } else {
            $_SESSION['error'] = "ไม่มีผู้ใช้ $email ในระบบ";
        }
        return false;
    }

    public function register() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $this->table_name WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $_SESSION['error'] = "มีผู้ใช้ $email อยู่แล้ว";
            } else {

                $status = ($role === "admin") ? 1 : 0;
                $stmt = $this->pdo->prepare("INSERT INTO $this->table_name (email, password, role, fname, lname, address, phone, status) VALUES (?,?,?,?,?,?,?,?)");
                $stmt->execute([$email, $hashedPassword, $role, $fname, $lname, $address, $phone, $status]);

                $_SESSION['success'] = "ลงทะเบียน $fname $lname สำเร็จ";
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
    }

    public function update() {
        $email = $_POST['email'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $profile_img = NULL;
    
        if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
            $newName = time() .'_'. $_FILES['profile_img']['name'];
            $uploadDir = '../uploads/profile/'. $newName;
            $profile_img = $url.$base.'uploads/profile/'. $newName;
            move_uploaded_file($_FILES['profile_img']['tmp_name'], $uploadDir);
        }
    
        if ($email && $fname && $lname && $address && $phone) {
            try {
                $stmt = $this->pdo->prepare("UPDATE $this->table_name SET email = ?, fname = ?, lname = ?, address = ?, phone = ? ". ($profile_img ? ', profile_img = ?' : '') ." WHERE id = ?");
                $param = [$email, $fname, $lname, $address, $phone];
                if ($profile_img) $param[] = $profile_img;
                $param[] = $_SESSION['user_login'];
                $stmt -> execute($param);
                $_SESSION['success'] = "อัพเดทโปรไฟล์ $fname $lname สำเร็จ";
            } catch (PDOException $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }
    }
}