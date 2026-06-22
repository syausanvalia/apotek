<?php
require_once '../config/database.php';

class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Login user
    public function login($email, $password) {
        try {
            $query = "SELECT id, name, email, password, role, phone, address 
                      FROM " . $this->table . " 
                      WHERE email = :email LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['password'])) {
                    return $row;
                }
            }
            return false;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Register pelanggan baru
    public function register($name, $email, $password, $phone, $address) {
        try {
            $query = "INSERT INTO " . $this->table . " 
                      (name, email, password, role, phone, address) 
                      VALUES (:name, :email, :password, 'pelanggan', :phone, :address)";
            
            $stmt = $this->conn->prepare($query);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get all apoteker (untuk admin)
    public function getAllApoteker() {
        $query = "SELECT id, name, email, phone, address, created_at 
                  FROM " . $this->table . " 
                  WHERE role = 'apoteker' 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create apoteker (untuk admin)
    public function createApoteker($name, $email, $password, $phone, $address) {
        try {
            $query = "INSERT INTO " . $this->table . " 
                      (name, email, password, role, phone, address) 
                      VALUES (:name, :email, :password, 'apoteker', :phone, :address)";
            
            $stmt = $this->conn->prepare($query);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update apoteker (untuk admin)
    public function updateApoteker($id, $name, $email, $phone, $address) {
        try {
            $query = "UPDATE " . $this->table . " 
                      SET name = :name, email = :email, phone = :phone, address = :address 
                      WHERE id = :id AND role = 'apoteker'";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
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

    // Delete apoteker (untuk admin)
    public function deleteApoteker($id) {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id AND role = 'apoteker'";
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

    // Get user by ID
    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
