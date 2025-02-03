<?php
class Users {
    private $pdo;
    private $table_name = "users";
    public $email;
    public $password;
    public $role;
    public $fname;
    public $lname;
    public $address;
    public $phone;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function isEmailExists($email) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $this->table_name WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; 
    }

    public function register() {
        if ($this->isEmailExists($this->email)) {
            echo "Error: Email already exists!";
            return false;
        }
        
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO $this->table_name (email, password, role, fname, lname, address, phone) VALUES (:email, :password, :role, :fname, :lname, :address, :phone)");
        $stmt->execute([
            ':email' => filter_var($this->email, FILTER_SANITIZE_EMAIL),
            ':password' => $hashedPassword,
            ':role' => strip_tags($this->role),
            ':fname' => strip_tags($this->fname),
            ':lname' => strip_tags($this->lname),
            ':address' => strip_tags($this->address),
            ':phone' => strip_tags($this->phone)
        ]);
    
        try {
            header('Location: /');
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function verifyPassword() {
        header('location: /');
        $query = "SELECT id, password, role FROM $this->table_name WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $data = $stmt->fetch();
            $hashedPassword = $data['password'];

            if (password_verify($this->password, $hashedPassword)) {
                $_SESSION['user_login'] = $data['id'];
                $_SESSION['role'] = $data['role'];
            } else {
                return false;
            }
        } 
        return false; 
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

    public function logOut() {
        unset($_SESSION['user_login']);
        header('location: /');
        exit;
    }
}