<?php
class Users {
    private $pdo;
    private $table_name = "users";

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function isEmailExists($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table_name WHERE email = ?");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function register($email, $password, $role, $fname, $lname, $address, $phone) {
        if ($this->isEmailExists($email)) {
            return false;
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO $this->table_name (email, password, role, fname, lname, address, phone) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([
            $email,
            $password,
            $role,
            $fname,
            $lname,
            $address,
            $phone
        ]);

        try {
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT id, password, role FROM $this->table_name WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() == 1) {
            $data = $stmt->fetch();
            $hashedPassword = $data['password'];
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_login'] = $data['id'];
                $_SESSION['role'] = $data['role'];
                $_SESSION['success'] = "Love";
            } else {
                $_SESSION['error'] = "Love";
            }
        } else {
            $_SESSION['error'] = "Love";
        }
    }

    public function useAuth() {
        if (isset($_SESSION['user_login'])) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_login']]);
            $user = $stmt->fetch();
            if ($user) {
                $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM shop WHERE user_id = ?");
                $stmt->execute([$user['id']]);
                $shopExists = $stmt->fetchColumn();
                if ($shopExists > 0) {
                    $stmt = $this->pdo->prepare("SELECT * FROM shop WHERE user_id = ?");
                    $stmt->execute([$user['id']]);
                    $shop = $stmt->fetch();
                    return ['user' => $user, 'hashshop' => true, 'shop' => $shop]; 
                }
                return ['user' => $user, 'hashshop' => false];
            } else {
                session_destroy();
                return null;
            }
        } else {
            return null;
        }
    }    

    public function logout() {
        unset($_SESSION['user_login']);
    }

    public function review() {

    }
}