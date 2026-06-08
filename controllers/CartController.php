<?php
require_once ROOT_PATH . '/models/Cart.php';
require_once ROOT_PATH . '/models/Product.php';

class CartController {

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['cart_error'] = "Connecte-toi pour voir ton panier";
            header("Location: /mkFashion/public/auth/loginForm");
            exit();
        }

        $cartModel = new Cart();
        $cartItems = $cartModel->getCartByUser($_SESSION['user_id']);
        $total = $cartModel->getTotal($_SESSION['user_id']);

        include ROOT_PATH . '/views/cart/index.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_id = (int)$_POST['cart_id'];
            $quantity = (int)$_POST['quantity'];

            $cartModel = new Cart();
            if ($quantity <= 0) {
                $cartModel->removeItem($cart_id);
            } else {
                $cartModel->updateQuantity($cart_id, $quantity);
            }
            
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit();
            }
            header("Location: /mkFashion/public/cart/index");
            exit();
        }
    }

    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_id = (int)$_POST['cart_id'];
            $cartModel = new Cart();
            $cartModel->removeItem($cart_id);
            
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit();
            }
            header("Location: /mkFashion/public/cart/index");
            exit();
        }
    }

    private function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function getCount() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['count' => 0]);
            exit();
        }
        
        $cartModel = new Cart();
        $count = $cartModel->getCartCount($_SESSION['user_id']);
        
        header('Content-Type: application/json');
        echo json_encode(['count' => $count]);
        exit();
    }

    // Modifier la méthode add pour retourner JSON si requête AJAX
    public function add() {
        if (!isset($_SESSION['user_id'])) {
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'connectez-vous']);
                exit();
            }
            $_SESSION['cart_error'] = "Connecte-toi d'abord";
            header("Location: /mkFashion/public/auth/loginForm");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = (int)$_POST['product_id'];
            $quantity = (int)($_POST['quantity'] ?? 1);

            $productModel = new Product();
            $product = $productModel->getById($product_id);

            if ($product && $product['stock'] >= $quantity) {
                $cartModel = new Cart();
                $cartModel->add($_SESSION['user_id'], $product_id, $quantity);
                $newCount = $cartModel->getCartCount($_SESSION['user_id']);
                
                if ($this->isAjax()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true, 
                        'message' => $product['name'] . ' ajouté au panier !',
                        'count' => $newCount,
                        'product_name' => $product['name'],
                        'product_price' => $product['price']
                    ]);
                    exit();
                }
                
                $_SESSION['cart_success'] = "✅ " . htmlspecialchars($product['name']) . " ajouté au panier !";
                header("Location: /mkFashion/public/cart/index");
            } else {
                if ($this->isAjax()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'Stock insuffisant']);
                    exit();
                }
                $_SESSION['cart_error'] = "Stock insuffisant pour ce produit";
                header("Location: /mkFashion/public/product/detail/" . $product_id);
            }
            exit();
        }
    }
}
?>