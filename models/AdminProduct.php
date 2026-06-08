<?php
require_once ROOT_PATH . '/config/database.php';

class AdminProduct {
    private $conn;
    private $table = "products";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM $this->table ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $desc, $price, $image, $stock) {
        $sql = "INSERT INTO $this->table (name, description, price, image_url, stock)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $desc, $price, $image, $stock]);
    }

    public function update($id, $name, $desc, $price, $image, $stock) {
        $sql = "UPDATE $this->table SET name=?, description=?, price=?, image_url=?, stock=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $desc, $price, $image, $stock, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>