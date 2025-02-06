<?php
class Users {
    private $pdo;
    private $table_name = "users";

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function exists($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table_name WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function register($email, $password, $role, $fname, $lname, $address, $phone) {
        if ($this->exists($email)) {
            $_SESSION['error'] = "มีผู้ใช้นี้อยู่แล้ว";
        }
        
        $stmt = $this->pdo->prepare("INSERT INTO $this->table_name (email, password, role, fname, lname, address, phone) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([$email, $password, $role, $fname, $lname, $address, $phone]);

        try {
            $_SESSION['success'] = "สมัครสมาชิก $email สำเร็จ";
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    public function login($email, $password) {
        if ($data = $this->exists($email)) {
            $hashedPassword = $data['password'];
            if ($password == $hashedPassword) {
                if ($data['status'] != 0) {
                    $_SESSION['user_login'] = $data['id'];
                    $_SESSION['role'] = $data['role'];
                } else {
                    $_SESSION['error'] = "GONEEEE NO ACCESS นะจ๊ะ 😘";
                }
          
            } else {
                $_SESSION['error'] = "รหัสผ่านของ $email ไม่ถูกต้อง";
            }
        } else {
            $_SESSION['error'] = "อีเมลไม่ถูกต้อง";
        }

        try {
            $_SESSION['success'] = "เข้าสู่ระบบ $email สำเร็จ";
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    public function useAuth() {
        if (isset($_SESSION['user_login'])) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_login']]);
            $user = $stmt->fetch();
            if ($user) {
                $stmt = $this->pdo->prepare("SELECT * FROM shop WHERE user_id = ?");
                $stmt->execute([$user['id']]);
                $shop = $stmt->fetch();
                if ($shop) {
                    return ['user' => $user, 'shop' => $shop]; 
                }
                return ['user' => $user, 'shop' => false];
            }
        }
    }    

    public function logout() {
        unset($_SESSION['user_login']);
    }
}