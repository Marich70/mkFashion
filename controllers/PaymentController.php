<?php
require_once ROOT_PATH . '/models/Payment.php';
require_once ROOT_PATH . '/models/Order.php';

class PaymentController {
    
    // Page de paiement
    public function checkout($order_id = null) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /mkFashion/public/auth/loginForm");
            exit();
        }
        
        if (!$order_id) {
            header("Location: /mkFashion/public/");
            exit();
        }
        
        $orderModel = new Order();
        $orderDetails = $orderModel->getOrderDetails($order_id);
        
        // Calculer le total
        $total = 0;
        foreach ($orderDetails as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Créer une session de paiement
        $paymentModel = new Payment();
        $session_id = $paymentModel->createPaymentSession($order_id, $total);
        
        include ROOT_PATH . '/views/payment/checkout.php';
    }
    
    // Simuler un paiement réussi
    public function success() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /mkFashion/public/auth/loginForm");
            exit();
        }
        
        $session_id = $_GET['session_id'] ?? null;
        if ($session_id) {
            $paymentModel = new Payment();
            $paymentModel->simulatePayment($session_id);
            $_SESSION['payment_success'] = "Paiement effectué avec succès !";
        }
        
        header("Location: /mkFashion/public/account/orders");
        exit();
    }
    
    // Simuler un paiement échoué
    public function cancel() {
        $_SESSION['payment_error'] = "Paiement annulé";
        header("Location: /mkFashion/public/account/orders");
        exit();
    }
}
?>