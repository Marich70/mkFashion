<?php
//Modèle utilisateur avec validation et sécurité
require_once ROOT_PATH . '/config/database.php';

class User {
    private $conn;
    private $table = "users";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Vérifier si email existe déjà
    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Inscription avec validation
    public function register($name, $email, $password, $confirm_password) {
        // Validation des champs
        $errors = [];
        
        if (empty($name)) {
            $errors[] = "Le nom est requis";
        } elseif (strlen($name) < 2) {
            $errors[] = "Le nom doit contenir au moins 2 caractères";
        }
        
        if (empty($email)) {
            $errors[] = "L'email est requis";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide";
        } elseif ($this->emailExists($email)) {
            $errors[] = "Cet email est déjà utilisé";
        }
        
        if (empty($password)) {
            $errors[] = "Le mot de passe est requis";
        } elseif (strlen($password) < 6) {
            $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
        }
        
        if ($password !== $confirm_password) {
            $errors[] = "Les mots de passe ne correspondent pas";
        }
        
        // Si erreurs, on les retourne
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        // Hashage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insertion
        $query = "INSERT INTO " . $this->table . " (name, email, password, role) 
                  VALUES (:name, :email, :password, 'client')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Inscription réussie ! Connectez-vous.'];
        } else {
            return ['success' => false, 'errors' => ['Erreur lors de l\'inscription']];
        }
    }

    // Connexion
    public function login($email, $password) {
        $errors = [];
        
        if (empty($email)) {
            $errors[] = "L'email est requis";
        }
        
        if (empty($password)) {
            $errors[] = "Le mot de passe est requis";
        }
        
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return ['success' => true, 'user' => $user];
        } else {
            return ['success' => false, 'errors' => ['Email ou mot de passe incorrect']];
        }
    }
}
?>