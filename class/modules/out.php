<?php 
class Cart {
    private $pdo;
    private $table_name = 'cart';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getCartByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table_name} WHERE uses_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function deleteCartItem($itemId) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table_name} WHERE id = ?");
        $stmt->execute([$itemId]);
    }
}

class Order {
    private $pdo;
    private $table_name = 'orders';
    private $order_detail_table = 'order_detail';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createOrder($userId, $shopId) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table_name} (date, delivery_status, user_id, shop_id) VALUES (NOW(), 0, ?, ?)");
        $stmt->execute([$userId, $shopId]);
        return $this->pdo->lastInsertId();
    }

    public function addOrderDetail($orderId, $foodId, $price, $discount, $qty) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->order_detail_table} (id, food_id, price, discount, qty) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$orderId, $foodId, $price, $discount, $qty]);
    }
}

class Checkout {
    private $pdo;
    private $cart;
    private $order;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->cart = new Cart($pdo);
        $this->order = new Order($pdo);
    }

    public function processCheckout($userId) {
        try {
            $cartItems = $this->cart->getCartByUserId($userId);
            $grouped = [];
            foreach ($cartItems as $item) {
                $grouped[$item['shop_id']][] = $item;
            }
            foreach ($grouped as $shopId => $items) {
                $orderId = $this->order->createOrder($userId, $shopId);
                foreach ($items as $item) {
                    $this->order->addOrderDetail($orderId, $item['food_id'], $item['price'], $item['discount'], $item['qty']);
                    $this->cart->deleteCartItem($item['id']);
                }
            }
            $_SESSION['success'] = "สั่งอาหารแล้ว Delivery มาส่งนะครับ 😁";
        } catch (PDOException $e) {
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
    }   
}

// $checkout = new Checkout($pdo);
// $checkout->processCheckout($_SESSION['user_login']);

?>