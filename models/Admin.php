<?php
require_once ROOT_PATH . '/config/database.php';

class Admin {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    // STATISTIQUES DASHBOARD
    public function getStats() {
        $stats = [];
        
        // Nombre de produits
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM products");
        $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Nombre d'utilisateurs
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'client'");
        $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Nombre de commandes
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM orders");
        $stats['total_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Chiffre d'affaires total
        $stmt = $this->conn->query("SELECT SUM(total_price) as total FROM orders WHERE status = 'paid' OR status = 'delivered'");
        $stats['total_revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        
        // Commandes en attente
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM orders WHERE status = 'pending'");
        $stats['pending_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Stock faible (moins de 10)
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM products WHERE stock < 10");
        $stats['low_stock'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return $stats;
    }
    
    // RÉCUPÉRER TOUS LES UTILISATEURS
    public function getAllUsers() {
        $stmt = $this->conn->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // CHANGER RÔLE UTILISATEUR
    public function updateUserRole($user_id, $role) {
        $stmt = $this->conn->prepare("UPDATE users SET role = :role WHERE id = :id");
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $user_id);
        return $stmt->execute();
    }
    
    // SUPPRIMER UTILISATEUR
    public function deleteUser($user_id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $user_id);
        return $stmt->execute();
    }
    
    // RÉCUPÉRER TOUTES LES COMMANDES
    public function getAllOrders() {
        $stmt = $this->conn->query("
            SELECT o.*, u.name as user_name, u.email 
            FROM orders o 
            JOIN users u ON o.user_id = u.id 
            ORDER BY o.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // CHANGER STATUT COMMANDE
    public function updateOrderStatus($order_id, $status) {
        $stmt = $this->conn->prepare("UPDATE orders SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $order_id);
        return $stmt->execute();
    }
    
    // RÉCUPÉRER DÉTAILS D'UNE COMMANDE
    public function getOrderDetails($order_id) {
        $stmt = $this->conn->prepare("
            SELECT oi.*, p.name, p.image_url 
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :order_id
        ");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>