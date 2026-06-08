<?php
require_once ROOT_PATH . '/config/database.php';

class Payment {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    // Créer une session de paiement
    public function createPaymentSession($order_id, $amount) {
        // Simulation d'un paiement (à remplacer par Stripe/PayPal plus tard)
        $session_id = uniqid('pay_');
        
        $query = "INSERT INTO payments (order_id, amount, status, session_id) 
                  VALUES (:order_id, :amount, 'pending', :session_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();
        
        return $session_id;
    }
    
    // Simuler un paiement réussi
    public function simulatePayment($session_id) {
        $query = "UPDATE payments SET status = 'paid', paid_at = NOW() WHERE session_id = :session_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':session_id', $session_id);
        
        if ($stmt->execute()) {
            // Mettre à jour le statut de la commande
            $this->updateOrderStatusBySession($session_id);
            return true;
        }
        return false;
    }
    
    private function updateOrderStatusBySession($session_id) {
        $query = "UPDATE orders o 
                  JOIN payments p ON o.id = p.order_id 
                  SET o.status = 'paid' 
                  WHERE p.session_id = :session_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();
    }
    
    // Récupérer le statut de paiement d'une commande
    public function getPaymentStatus($order_id) {
        $query = "SELECT * FROM payments WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>