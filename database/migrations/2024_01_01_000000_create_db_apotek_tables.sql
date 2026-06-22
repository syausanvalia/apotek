-- Database untuk Aplikasi Apotek
CREATE DATABASE IF NOT EXISTS db_apotek CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_apotek;

-- Tabel Users (untuk Admin, Apoteker, dan Pelanggan)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'apoteker', 'pelanggan') NOT NULL DEFAULT 'pelanggan',
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Suppliers
CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact_person VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(255),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Medicines (Obat)
CREATE TABLE IF NOT EXISTS medicines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    supplier_id INT,
    expiry_date DATE,
    status ENUM('available', 'expired', 'out_of_stock') DEFAULT 'available',
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL
);

-- Tabel Purchases (Pembelian Obat dari Supplier)
CREATE TABLE IF NOT EXISTS purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT NOT NULL,
    medicine_id INT NOT NULL,
    quantity INT NOT NULL,
    purchase_price DECIMAL(10, 2) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    purchase_date DATE NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE,
    FOREIGN KEY (medicine_id) REFERENCES medicines(id) ON DELETE CASCADE
);

-- Tabel Sales (Penjualan Obat ke Pelanggan)
CREATE TABLE IF NOT EXISTS sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    medicine_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    sale_date DATETIME NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (medicine_id) REFERENCES medicines(id) ON DELETE CASCADE
);

-- Data default untuk Admin
INSERT INTO users (name, email, password, role, phone, address) VALUES
('Admin Utama', 'admin@apotek.com', '$2y$12$LKvH/7.XqRZM9K3pN5jVhOYwGx8F2qR3tU6vW7xY8zA9bC0dE1fG2h', 'admin', '081234567890', 'Jl. Apotek No. 1');

-- Data default untuk Apoteker
INSERT INTO users (name, email, password, role, phone, address) VALUES
('Apoteker Satu', 'apoteker@apotek.com', '$2y$12$LKvH/7.XqRZM9K3pN5jVhOYwGx8F2qR3tU6vW7xY8zA9bC0dE1fG2h', 'apoteker', '081234567891', 'Jl. Apotek No. 2');

-- Data default untuk Supplier
INSERT INTO suppliers (name, contact_person, phone, email, address) VALUES
('PT. Farma Jaya', 'Budi Santoso', '081111111111', 'contact@farmajaya.com', 'Jakarta'),
('CV. Medika Sejahtera', 'Siti Aminah', '082222222222', 'info@medikasejahtera.com', 'Bandung');

-- Data default untuk Obat
INSERT INTO medicines (name, description, category, price, stock, supplier_id, expiry_date, status) VALUES
('Paracetamol 500mg', 'Obat penurun panas dan pereda nyeri', 'Obat Bebas', 5000, 100, 1, '2026-12-31', 'available'),
('Amoxicillin 500mg', 'Antibiotik untuk infeksi bakteri', 'Obat Keras', 15000, 50, 1, '2026-06-30', 'available'),
('Vitamin C 1000mg', 'Suplemen vitamin C untuk daya tahan tubuh', 'Suplemen', 25000, 75, 2, '2027-01-15', 'available'),
('OBH Combi', 'Obat batuk berdahak', 'Obat Bebas', 18000, 60, 2, '2025-11-20', 'available'),
('Promag', 'Obat maag dan gangguan pencernaan', 'Obat Bebas', 8000, 80, 1, '2026-08-10', 'available');
