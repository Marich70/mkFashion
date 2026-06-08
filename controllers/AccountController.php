<?php
require_once ROOT_PATH . '/models/Order.php';
require_once ROOT_PATH . '/models/Payment.php';

class AccountController {
    
    private function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /mkFashion/public/auth/loginForm");
            exit();
        }
    }
    
    // Mes commandes
    public function orders() {
        $this->checkAuth();
        
        $orderModel = new Order();
        $orders = $orderModel->getUserOrders($_SESSION['user_id']);
        
        include ROOT_PATH . '/views/account/orders.php';
    }
    
    // Détail d'une commande
    public function orderDetail($id = null) {
        $this->checkAuth();
        
        if (!$id) {
            header("Location: /mkFashion/public/account/orders");
            exit();
        }
        
        $orderModel = new Order();
        $orderDetails = $orderModel->getOrderDetails($id);
        
        // Récupérer la commande elle-même pour le statut
        $userOrders = $orderModel->getUserOrders($_SESSION['user_id']);
        $currentOrder = null;
        foreach ($userOrders as $order) {
            if ($order['id'] == $id) {
                $currentOrder = $order;
                break;
            }
        }
        
        if (!$currentOrder) {
            header("Location: /mkFashion/public/account/orders");
            exit();
        }
        
        $paymentModel = new Payment();
        $payment = $paymentModel->getPaymentStatus($id);
        
        // Passer les deux variables à la vue
        include ROOT_PATH . '/views/account/order_detail.php';
    }
    
    // Payer une commande
    public function pay($id = null) {
        $this->checkAuth();
        
        if (!$id) {
            header("Location: /mkFashion/public/account/orders");
            exit();
        }
        
        header("Location: /mkFashion/public/payment/checkout/" . $id);
        exit();
    }
}
?>