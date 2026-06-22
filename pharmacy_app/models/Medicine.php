<?php
require_once '../config/database.php';

class Medicine {
    private $conn;
    private $table = 'medicines';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all medicines
    public function getAll() {
        $query = "SELECT m.id, m.name, m.description, m.category, m.price, m.stock, 
                         m.expiry_date, m.status, m.image, m.created_at,
                         s.name as supplier_name
                  FROM " . $this->table . " m
                  LEFT JOIN suppliers s ON m.supplier_id = s.id
                  ORDER BY m.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get medicine by ID
    public function getById($id) {
        $query = "SELECT m.id, m.name, m.description, m.category, m.price, m.stock, 
                         m.expiry_date, m.status, m.image, m.created_at,
                         s.name as supplier_name, s.id as supplier_id
                  FROM " . $this->table . " m
                  LEFT JOIN suppliers s ON m.supplier_id = s.id
                  WHERE m.id = :id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Search medicines
    public function search($keyword) {
        $query = "SELECT m.id, m.name, m.description, m.category, m.price, m.stock, 
                         m.expiry_date, m.status, m.image,
                         s.name as supplier_name
                  FROM " . $this->table . " m
                  LEFT JOIN suppliers s ON m.supplier_id = s.id
                  WHERE m.name LIKE :keyword OR m.description LIKE :keyword OR m.category LIKE :keyword
                  ORDER BY m.name ASC";
        
        $stmt = $this->conn->prepare($query);
        $searchTerm = "%{$keyword}%";
        $stmt->bindParam(':keyword', $searchTerm);
        $stmt->execute();
        return $stmt;
    }

    // Create medicine (Admin & Apoteker)
    public function create($name, $description, $category, $price, $stock, $supplier_id, $expiry_date, $image = null) {
        try {
            $query = "INSERT INTO " . $this->table . " 
                      (name, description, category, price, stock, supplier_id, expiry_date, status, image) 
                      VALUES (:name, :description, :category, :price, :stock, :supplier_id, :expiry_date, 'available', :image)";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':supplier_id', $supplier_id);
            $stmt->bindParam(':expiry_date', $expiry_date);
            $stmt->bindParam(':image', $image);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update medicine (Admin & Apoteker)
    public function update($id, $name, $description, $category, $price, $stock, $supplier_id, $expiry_date, $status, $image = null) {
        try {
            $query = "UPDATE " . $this->table . " 
                      SET name = :name, description = :description, category = :category, 
                          price = :price, stock = :stock, supplier_id = :supplier_id, 
                          expiry_date = :expiry_date, status = :status";
            
            if ($image !== null) {
                $query .= ", image = :image";
            }
            
            $query .= " WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':supplier_id', $supplier_id);
            $stmt->bindParam(':expiry_date', $expiry_date);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            
            if ($image !== null) {
                $stmt->bindParam(':image', $image);
            }

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete medicine (Admin & Apoteker)
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

    // Get expired medicines (untuk Admin)
    public function getExpiredMedicines() {
        $query = "SELECT m.id, m.name, m.description, m.category, m.price, m.stock, 
                         m.expiry_date, m.status,
                         s.name as supplier_name
                  FROM " . $this->table . " m
                  LEFT JOIN suppliers s ON m.supplier_id = s.id
                  WHERE m.expiry_date <= CURDATE() OR m.status = 'expired'
                  ORDER BY m.expiry_date ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get medicines expiring soon (untuk Admin)
    public function getExpiringSoon($days = 30) {
        $query = "SELECT m.id, m.name, m.description, m.category, m.price, m.stock, 
                         m.expiry_date, m.status,
                         s.name as supplier_name
                  FROM " . $this->table . " m
                  LEFT JOIN suppliers s ON m.supplier_id = s.id
                  WHERE m.expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL :days DAY)
                  AND m.status != 'expired'
                  ORDER BY m.expiry_date ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':days', $days, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Update stock
    public function updateStock($id, $stock) {
        try {
            $query = "UPDATE " . $this->table . " SET stock = :stock WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':stock', $stock);
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

    // Get total medicines sold
    public function getTotalSold() {
        $query = "SELECT COALESCE(SUM(sd.quantity), 0) as total_sold 
                  FROM sale_details sd
                  JOIN sales s ON sd.sale_id = s.id
                  WHERE s.status = 'completed'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_sold'];
    }
}
?>
