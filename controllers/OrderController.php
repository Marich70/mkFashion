<?php
// Logique de validation de commande
require_once ROOT_PATH . '/models/Cart.php';
require_once ROOT_PATH . '/models/Order.php';

class OrderController {
    
    // Valider la commande
    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /mkFashion/public/auth/loginForm");
            exit();
        }
        
        $cartModel = new Cart();
        
        // Vérifier si le panier n'est pas vide
        if ($cartModel->isEmpty($_SESSION['user_id'])) {
            header("Location: /mkFashion/public/cart/index");
            exit();
        }
        
        $cartItems = $cartModel->getCartByUser($_SESSION['user_id']);
        $total = $cartModel->getTotal($_SESSION['user_id']);
        
        // Créer la commande
        $orderModel = new Order();
        $order_id = $orderModel->createOrder($_SESSION['user_id'], $cartItems, $total);
        
        if ($order_id) {
            // Vider le panier
            $cartModel->clearCart($_SESSION['user_id']);
            
            // Rediriger vers la page de succès
            header("Location: /mkFashion/public/order/success?order_id=" . $order_id);
            exit();
        } else {
            echo "Erreur lors de la validation de la commande. Stock peut-être insuffisant.";
        }
    }
    
    // Page de succès
    public function success() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /mkFashion/public/auth/loginForm");
        exit();
    }
    
    $order_id = $_GET['order_id'] ?? null;
    if (!$order_id) {
        header("Location: /mkFashion/public/product/index");
        exit();
    }
    
    $orderModel = new Order();
    $orderDetails = $orderModel->getOrderDetails($order_id);
    
    // Récupérer les infos de la commande
    require_once ROOT_PATH . '/config/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("SELECT status, created_at, total_price FROM orders WHERE id = ?");
    $stmt->execute([$order_id]);
    $orderInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    include ROOT_PATH . '/views/order/success.php';
}
    
    // Historique des commandes
    public function history() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /mkFashion/public/auth/loginForm");
            exit();
        }
        
        $orderModel = new Order();
        $orders = $orderModel->getUserOrders($_SESSION['user_id']);
        
        include ROOT_PATH . '/views/order/history.php';
    }
}
?>