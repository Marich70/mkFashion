<?php
//connexion PDO sécurisée
class Database {
    private $host = "localhost";
    private $db_name = "mkfashion";
    private $username = "root";
    private $password = "maig2004";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erreur BDD : " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>