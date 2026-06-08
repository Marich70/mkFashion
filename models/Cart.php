<?php
require_once ROOT_PATH . '/config/database.php';

class Cart {
    private $conn;
    private $table = "carts";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function add($user_id, $product_id, $quantity = 1) {
        $checkQuery = "SELECT * FROM " . $this->table . " 
                       WHERE user_id = :user_id AND product_id = :product_id";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':user_id', $user_id);
        $checkStmt->bindParam(':product_id', $product_id);
        $checkStmt->execute();
        
        $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existing) {
            $newQuantity = $existing['quantity'] + $quantity;
            $updateQuery = "UPDATE " . $this->table . " 
                           SET quantity = :quantity 
                           WHERE id = :id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':quantity', $newQuantity);
            $updateStmt->bindParam(':id', $existing['id']);
            return $updateStmt->execute();
        } else {
            $insertQuery = "INSERT INTO " . $this->table . " 
                           (user_id, product_id, quantity) 
                           VALUES (:user_id, :product_id, :quantity)";
            $insertStmt = $this->conn->prepare($insertQuery);
            $insertStmt->bindParam(':user_id', $user_id);
            $insertStmt->bindParam(':product_id', $product_id);
            $insertStmt->bindParam(':quantity', $quantity);
            return $insertStmt->execute();
        }
    }

    public function getCartByUser($user_id) {
        $query = "SELECT c.*, p.name, p.price, p.image_url, p.stock 
                  FROM " . $this->table . " c
                  JOIN products p ON c.product_id = p.id
                  WHERE c.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotal($user_id) {
        $cartItems = $this->getCartByUser($user_id);
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function updateQuantity($cart_id, $quantity) {
        $query = "UPDATE " . $this->table . " 
                  SET quantity = :quantity 
                  WHERE id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':cart_id', $cart_id);
        return $stmt->execute();
    }

    public function removeItem($cart_id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id);
        return $stmt->execute();
    }

    public function clearCart($user_id) {
        $query = "DELETE FROM " . $this->table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    public function isEmpty($user_id) {
        $items = $this->getCartByUser($user_id);
        return count($items) === 0;
    }

    public function getCartCount($user_id) {
        $query = "SELECT SUM(quantity) as total FROM " . $this->table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
?>