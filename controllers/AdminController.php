<?php
require_once ROOT_PATH . '/models/AdminProduct.php';
require_once ROOT_PATH . '/models/Admin.php';

class AdminController {
    
    private function checkAdmin() {
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
            header("Location: /mkFashion/public/");
            exit();
        }
    }
    
    // ========== DASHBOARD ==========
    public function index() {
        $this->checkAdmin();
        $adminModel = new Admin();
        $stats = $adminModel->getStats();
        include ROOT_PATH . '/views/admin/dashboard.php';
    }
    
    // ========== GESTION PRODUITS ==========
    public function products() {
        $this->checkAdmin();
        $model = new AdminProduct();
        $products = $model->getAll();
        include ROOT_PATH . '/views/admin/products.php';
    }
    
    public function createProduct() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new AdminProduct();
            $model->create(
                $_POST['name'],
                $_POST['description'],
                $_POST['price'],
                $_POST['image_url'],
                $_POST['stock']
            );
            $_SESSION['admin_success'] = "Produit ajouté avec succès !";
            header("Location: /mkFashion/public/admin/products");
            exit();
        }
        include ROOT_PATH . '/views/admin/product_form.php';
    }
    
    public function editProduct($id = null) {
        $this->checkAdmin();
        if (!$id) {
            header("Location: /mkFashion/public/admin/products");
            exit();
        }
        
        $model = new AdminProduct();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model->update(
                $id,
                $_POST['name'],
                $_POST['description'],
                $_POST['price'],
                $_POST['image_url'],
                $_POST['stock']
            );
            $_SESSION['admin_success'] = "Produit modifié avec succès !";
            header("Location: /mkFashion/public/admin/products");
            exit();
        }
        
        $product = $model->getById($id);
        include ROOT_PATH . '/views/admin/product_form.php';
    }
    
    public function deleteProduct($id = null) {
        $this->checkAdmin();
        if ($id) {
            $model = new AdminProduct();
            $model->delete($id);
            $_SESSION['admin_success'] = "Produit supprimé !";
        }
        header("Location: /mkFashion/public/admin/products");
        exit();
    }
    
    // ========== GESTION UTILISATEURS ==========
    public function users() {
        $this->checkAdmin();
        $adminModel = new Admin();
        $users = $adminModel->getAllUsers();
        include ROOT_PATH . '/views/admin/users.php';
    }
    
    public function updateUserRole() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = new Admin();
            $adminModel->updateUserRole($_POST['user_id'], $_POST['role']);
            $_SESSION['admin_success'] = "Rôle utilisateur mis à jour !";
        }
        header("Location: /mkFashion/public/admin/users");
        exit();
    }
    
    public function deleteUser($id = null) {
        $this->checkAdmin();
        if ($id && $id != $_SESSION['user_id']) { // Éviter de se supprimer soi-même
            $adminModel = new Admin();
            $adminModel->deleteUser($id);
            $_SESSION['admin_success'] = "Utilisateur supprimé !";
        }
        header("Location: /mkFashion/public/admin/users");
        exit();
    }
    
    // ========== GESTION COMMANDES ==========
    public function orders() {
        $this->checkAdmin();
        $adminModel = new Admin();
        $orders = $adminModel->getAllOrders();
        include ROOT_PATH . '/views/admin/orders.php';
    }
    
    public function updateOrderStatus() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = new Admin();
            $adminModel->updateOrderStatus($_POST['order_id'], $_POST['status']);
            $_SESSION['admin_success'] = "Statut de commande mis à jour !";
        }
        header("Location: /mkFashion/public/admin/orders");
        exit();
    }
    
    public function orderDetail($id = null) {
        $this->checkAdmin();
        if (!$id) {
            header("Location: /mkFashion/public/admin/orders");
            exit();
        }
        
        $adminModel = new Admin();
        $orderDetails = $adminModel->getOrderDetails($id);
        include ROOT_PATH . '/views/admin/order_detail.php';
    }
}
?>