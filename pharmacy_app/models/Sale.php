<?php
require_once '../config/database.php';

class Sale {
    private $conn;
    private $table = 'sales';
    private $detailTable = 'sale_details';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create sale
    public function createSale($customer_id, $apoteker_id, $total_amount, $items) {
        try {
            $this->conn->beginTransaction();

            // Insert ke tabel sales
            $query = "INSERT INTO " . $this->table . " 
                      (customer_id, apoteker_id, total_amount, status) 
                      VALUES (:customer_id, :apoteker_id, :total_amount, 'completed')";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->bindParam(':apoteker_id', $apoteker_id);
            $stmt->bindParam(':total_amount', $total_amount);
            $stmt->execute();

            $sale_id = $this->conn->lastInsertId();

            // Insert ke tabel sale_details
            foreach ($items as $item) {
                $detailQuery = "INSERT INTO " . $this->detailTable . " 
                               (sale_id, medicine_id, quantity, price, subtotal) 
                               VALUES (:sale_id, :medicine_id, :quantity, :price, :subtotal)";
                
                $detailStmt = $this->conn->prepare($detailQuery);
                $detailStmt->bindParam(':sale_id', $sale_id);
                $detailStmt->bindParam(':medicine_id', $item['medicine_id']);
                $detailStmt->bindParam(':quantity', $item['quantity']);
                $detailStmt->bindParam(':price', $item['price']);
                $detailStmt->bindParam(':subtotal', $item['subtotal']);
                $detailStmt->execute();

                // Update stock obat
                $updateStock = "UPDATE medicines SET stock = stock - :quantity WHERE id = :medicine_id";
                $stockStmt = $this->conn->prepare($updateStock);
                $stockStmt->bindParam(':quantity', $item['quantity']);
                $stockStmt->bindParam(':medicine_id', $item['medicine_id']);
                $stockStmt->execute();
            }

            $this->conn->commit();
            return $sale_id;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get all sales (untuk Admin & Apoteker)
    public function getAll() {
        $query = "SELECT s.id, s.customer_id, s.apoteker_id, s.total_amount, s.sale_date, s.status,
                         c.name as customer_name, a.name as apoteker_name
                  FROM " . $this->table . " s
                  LEFT JOIN users c ON s.customer_id = c.id
                  LEFT JOIN users a ON s.apoteker_id = a.id
                  ORDER BY s.sale_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get sale by ID
    public function getById($id) {
        $query = "SELECT s.id, s.customer_id, s.apoteker_id, s.total_amount, s.sale_date, s.status,
                         c.name as customer_name, a.name as apoteker_name
                  FROM " . $this->table . " s
                  LEFT JOIN users c ON s.customer_id = c.id
                  LEFT JOIN users a ON s.apoteker_id = a.id
                  WHERE s.id = :id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get sale details
    public function getSaleDetails($sale_id) {
        $query = "SELECT sd.id, sd.medicine_id, sd.quantity, sd.price, sd.subtotal,
                         m.name as medicine_name
                  FROM " . $this->detailTable . " sd
                  LEFT JOIN medicines m ON sd.medicine_id = m.id
                  WHERE sd.sale_id = :sale_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sale_id', $sale_id);
        $stmt->execute();
        return $stmt;
    }

    // Get sales by customer (untuk Pelanggan - histori pembelian)
    public function getByCustomer($customer_id) {
        $query = "SELECT s.id, s.total_amount, s.sale_date, s.status
                  FROM " . $this->table . " s
                  WHERE s.customer_id = :customer_id
                  ORDER BY s.sale_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        return $stmt;
    }

    // Get sales by apoteker (untuk Apoteker)
    public function getByApoteker($apoteker_id) {
        $query = "SELECT s.id, s.customer_id, s.total_amount, s.sale_date, s.status,
                         c.name as customer_name
                  FROM " . $this->table . " s
                  LEFT JOIN users c ON s.customer_id = c.id
                  WHERE s.apoteker_id = :apoteker_id
                  ORDER BY s.sale_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':apoteker_id', $apoteker_id);
        $stmt->execute();
        return $stmt;
    }

    // Get total sales amount
    public function getTotalSales() {
        $query = "SELECT COALESCE(SUM(total_amount), 0) as total_sales 
                  FROM " . $this->table . " 
                  WHERE status = 'completed'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_sales'];
    }

    // Get total transactions
    public function getTotalTransactions() {
        $query = "SELECT COUNT(*) as total_transactions 
                  FROM " . $this->table . " 
                  WHERE status = 'completed'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_transactions'];
    }
}
?>
