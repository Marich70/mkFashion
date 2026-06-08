<?php
require_once ROOT_PATH . '/models/Product.php';

class ProductController {
    
    public function index() {
        $productModel = new Product();
        $products = $productModel->getAll(); // Ici on récupère les produits
        
        // Inclure la vue
        include ROOT_PATH . '/views/products/list.php';
    }

    public function detail($id = null) {
        if ($id === null) {
            header("Location: /mkFashion/public/");
            exit();
        }
        
        $productModel = new Product();
        $product = $productModel->getById($id);
        
        if (!$product) {
            die("❌ Produit non trouvé");
        }
        
        include ROOT_PATH . '/views/products/detail.php';
    }
}
?>