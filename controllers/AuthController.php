<?php
require_once ROOT_PATH . '/models/User.php';

class AuthController {
    
    // Afficher formulaire inscription
    public function registerForm() {
        $errors = $_SESSION['register_errors'] ?? [];
        $old_input = $_SESSION['old_input'] ?? [];
        unset($_SESSION['register_errors'], $_SESSION['old_input']);
        
        include ROOT_PATH . '/views/auth/register.php';
    }
    
    // Traiter inscription
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $result = $userModel->register(
                $_POST['name'] ?? '',
                $_POST['email'] ?? '',
                $_POST['password'] ?? '',
                $_POST['confirm_password'] ?? ''
            );
            
            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
                header("Location: /mkFashion/public/auth/loginForm");
                exit();
            } else {
                $_SESSION['register_errors'] = $result['errors'];
                $_SESSION['old_input'] = [
                    'name' => $_POST['name'] ?? '',
                    'email' => $_POST['email'] ?? ''
                ];
                header("Location: /mkFashion/public/auth/registerForm");
                exit();
            }
        }
    }
    
    // Afficher formulaire connexion
    public function loginForm() {
        $errors = $_SESSION['login_errors'] ?? [];
        $success = $_SESSION['success_message'] ?? '';
        unset($_SESSION['login_errors'], $_SESSION['success_message']);
        
        include ROOT_PATH . '/views/auth/login.php';
    }
    
    // Traiter connexion
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $result = $userModel->login(
                $_POST['email'] ?? '',
                $_POST['password'] ?? ''
            );
            
            if ($result['success']) {
                $_SESSION['user_id'] = $result['user']['id'];
                $_SESSION['user_name'] = $result['user']['name'];
                $_SESSION['user_email'] = $result['user']['email'];
                $_SESSION['user_role'] = $result['user']['role'];
                header("Location: /mkFashion/public/");
                exit();
            } else {
                $_SESSION['login_errors'] = $result['errors'];
                header("Location: /mkFashion/public/auth/loginForm");
                exit();
            }
        }
    }
    
    // Déconnexion
    public function logout() {
        session_destroy();
        header("Location: /mkFashion/public/");
        exit();
    }
}
?>