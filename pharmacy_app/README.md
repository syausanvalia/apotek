# Aplikasi Apotek - Sistem Manajemen Apotek

## Deskripsi
Aplikasi web untuk manajemen apotek dengan 3 jenis pengguna: Admin, Apoteker, dan Pelanggan.

## Teknologi
- **Backend**: PHP (Native)
- **Frontend**: HTML, CSS, JavaScript
- **Framework CSS**: Bootstrap 5
- **Database**: MySQL
- **Icons**: Font Awesome

## Fitur Berdasarkan User Role

### Admin
- Login ke dashboard
- Mendaftarkan Apoteker
- Mendaftarkan Obat
- Mendaftarkan Supplier
- Mendaftarkan Pelanggan
- Menambahkan, mengedit, atau menghapus data obat
- Mencari obat yang akan kadaluarsa
- Melihat report penjualan obat
- Melihat daftar obat
- Melihat daftar supplier
- Melihat daftar pembelian obat
- Mengubah status obat

### Apoteker
- Login ke dashboard
- Mengakses halaman utama dengan data obat
- Menambahkan data obat dan detail obat
- Menambahkan data penjualan obat
- Mencari obat
- Menghapus obat lama
- Melihat histori penjualan obat
- Menghapus data obat kadaluarsa

### Pelanggan
- Membuat akun baru (Sign Up)
- Login ke dashboard
- Melihat obat dan detail obat
- Melakukan pembelian obat
- Melihat histori pembelian

## Struktur Database

### Tabel Users
- id, name, email, password, role, phone, address, created_at, updated_at

### Tabel Suppliers
- id, name, contact_person, phone, email, address, created_at, updated_at

### Tabel Medicines
- id, name, description, category, price, stock, supplier_id, expiry_date, status, image, created_at, updated_at

### Tabel Purchases
- id, supplier_id, medicine_id, quantity, purchase_price, total_price, purchase_date, status, created_at, updated_at

### Tabel Sales
- id, customer_id, apoteker_id, total_amount, sale_date, status, created_at, updated_at

### Tabel Sale Details
- id, sale_id, medicine_id, quantity, price, subtotal, created_at

## Instalasi

1. Clone repository ini
2. Buat database MySQL bernama `db_apotek`
3. Import file SQL dari folder `database/db_apotek.sql`
4. Konfigurasi koneksi database di `config/database.php`
5. Akses aplikasi melalui browser

## Default Login Credentials

**Admin:**
- Email: admin@apotek.com
- Password: password

## Struktur Folder

```
pharmacy_app/
├── config/
│   ├── database.php      # Konfigurasi database
│   └── helpers.php       # Fungsi helper
├── models/
│   ├── User.php          # Model user
│   ├── Medicine.php      # Model obat
│   ├── Sale.php          # Model penjualan
│   ├── Purchase.php      # Model pembelian
│   └── Supplier.php      # Model supplier
├── views/
│   ├── layouts/
│   │   └── main.php      # Layout utama
│   ├── auth/
│   │   ├── login.php     # Halaman login
│   │   ├── signup.php    # Halaman sign up
│   │   └── logout.php    # Logout handler
│   ├── admin/            # Halaman admin
│   ├── apoteker/         # Halaman apoteker
│   └── pelanggan/        # Halaman pelanggan
├── public/
│   ├── css/
│   │   └── style.css     # Custom CSS
│   └── js/
│       └── main.js       # Custom JavaScript
└── database/
    └── db_apotek.sql     # File SQL database
```

## Halaman Aplikasi

1. **Halaman Utama** - Menampilkan daftar obat yang terjual dan jumlah obat
2. **Detail Obat** - Menampilkan detail obat ketika nama obat diklik
3. **Detail Penjualan** - Menampilkan detail penjualan
4. **Sign Up** - Untuk user yang ingin mendaftar sebagai pelanggan
5. **Login** - Untuk semua user (admin, apoteker, pelanggan)
6. **Daftar Obat** - Untuk melihat obat yang dijual (pelanggan)
7. **Tambah Obat** - Untuk menambah obat baru (apoteker)
8. **Hapus Obat** - Untuk menghapus obat lama (apoteker)
9. **Histori Penjualan** - Untuk melihat histori penjualan (apoteker)
10. **Obat Kadaluarsa** - Untuk menghapus data obat kadaluarsa (apoteker/admin)
11. **Daftar Apoteker** - Untuk admin melihat daftar apoteker
12. **Daftar Pembelian** - Untuk admin melihat daftar pembelian obat
13. **Daftar Supplier** - Untuk admin melihat daftar supplier
14. **Kelola Apoteker** - Untuk admin mendaftarkan/mengedit apoteker

## License
MIT License
