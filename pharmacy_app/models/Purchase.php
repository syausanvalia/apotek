<?php
require_once '../config/database.php';

class Purchase {
    private $conn;
    private $table = 'purchases';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all purchases
    public function getAll() {
        $query = "SELECT p.id, p.supplier_id, p.medicine_id, p.quantity, 
                         p.purchase_price, p.total_price, p.purchase_date, p.status,
                         s.name as supplier_name, m.name as medicine_name
                  FROM " . $this->table . " p
                  LEFT JOIN suppliers s ON p.supplier_id = s.id
                  LEFT JOIN medicines m ON p.medicine_id = m.id
                  ORDER BY p.purchase_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get purchase by ID
    public function getById($id) {
        $query = "SELECT p.*, s.name as supplier_name, m.name as medicine_name
                  FROM " . $this->table . " p
                  LEFT JOIN suppliers s ON p.supplier_id = s.id
                  LEFT JOIN medicines m ON p.medicine_id = m.id
                  WHERE p.id = :id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create purchase
    public function create($supplier_id, $medicine_id, $quantity, $purchase_price, $total_price, $purchase_date) {
        try {
            $query = "INSERT INTO " . $this->table . " 
                      (supplier_id, medicine_id, quantity, purchase_price, total_price, purchase_date, status) 
                      VALUES (:supplier_id, :medicine_id, :quantity, :purchase_price, :total_price, :purchase_date, 'completed')";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':supplier_id', $supplier_id);
            $stmt->bindParam(':medicine_id', $medicine_id);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':purchase_price', $purchase_price);
            $stmt->bindParam(':total_price', $total_price);
            $stmt->bindParam(':purchase_date', $purchase_date);

            if ($stmt->execute()) {
                // Update stock obat
                $updateStock = "UPDATE medicines SET stock = stock + :quantity WHERE id = :medicine_id";
                $stockStmt = $this->conn->prepare($updateStock);
                $stockStmt->bindParam(':quantity', $quantity);
                $stockStmt->bindParam(':medicine_id', $medicine_id);
                $stockStmt->execute();
                
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update purchase status
    public function updateStatus($id, $status) {
        try {
            $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete purchase
    public function delete($id) {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get total purchases amount
    public function getTotalPurchases() {
        $query = "SELECT COALESCE(SUM(total_price), 0) as total_purchases 
                  FROM " . $this->table . " 
                  WHERE status = 'completed'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_purchases'];
    }
}
?>
