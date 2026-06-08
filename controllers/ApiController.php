<?php
require_once ROOT_PATH . '/models/Admin.php';

class ApiController {
    
    public function recentOrders() {
        header('Content-Type: application/json');
        
        $adminModel = new Admin();
        $orders = $adminModel->getAllOrders();
        $recent = array_slice($orders, 0, 5);
        
        echo json_encode($recent);
        exit();
    }
}
?>