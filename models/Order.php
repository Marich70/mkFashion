<?php
//les commandes et leur validation
require_once ROOT_PATH . '/config/database.php';


class Order {
    private $conn;
    private $table_orders = "orders";
    private $table_items = "order_items";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Créer une commande à partir du panier
    public function createOrder($user_id, $cartItems, $total) {
        try {
            // Démarrer une transaction (tout ou rien)
            $this->conn->beginTransaction();
            
            // 1. Insérer la commande principale
            $orderQuery = "INSERT INTO " . $this->table_orders . " 
                          (user_id, total_price, status) 
                          VALUES (:user_id, :total, 'pending')";
            $orderStmt = $this->conn->prepare($orderQuery);
            $orderStmt->bindParam(':user_id', $user_id);
            $orderStmt->bindParam(':total', $total);
            $orderStmt->execute();
            
            $order_id = $this->conn->lastInsertId();
            
            // 2. Insérer chaque article dans order_items
            $itemQuery = "INSERT INTO " . $this->table_items . " 
                         (order_id, product_id, quantity, price) 
                         VALUES (:order_id, :product_id, :quantity, :price)";
            $itemStmt = $this->conn->prepare($itemQuery);
            
            foreach ($cartItems as $item) {
                $itemStmt->bindParam(':order_id', $order_id);
                $itemStmt->bindParam(':product_id', $item['product_id']);
                $itemStmt->bindParam(':quantity', $item['quantity']);
                $itemStmt->bindParam(':price', $item['price']);
                $itemStmt->execute();
                
                // 3. Mettre à jour le stock (déduire les quantités commandées)
                $this->updateStock($item['product_id'], $item['quantity']);
            }
            
            // Tout est bon, on valide
            $this->conn->commit();
            return $order_id;
            
        } catch(Exception $e) {
            // En cas d'erreur, on annule tout
            $this->conn->rollBack();
            return false;
        }
    }
    
    // Mettre à jour le stock produit
    private function updateStock($product_id, $quantity) {
        $query = "UPDATE products 
                  SET stock = stock - :quantity 
                  WHERE id = :product_id AND stock >= :quantity";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':product_id', $product_id);
        return $stmt->execute();
    }
    
    // Récupérer les commandes d'un utilisateur
    public function getUserOrders($user_id) {
        $query = "SELECT * FROM " . $this->table_orders . " 
                  WHERE user_id = :user_id 
                  ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Récupérer les détails d'une commande spécifique
    public function getOrderDetails($order_id) {
        $query = "SELECT oi.*, p.name, p.image_url 
                  FROM " . $this->table_items . " oi
                  JOIN products p ON oi.product_id = p.id
                  WHERE oi.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>