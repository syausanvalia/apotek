# Aplikasi Apotek - Laravel

Aplikasi manajemen apotek berbasis web menggunakan Laravel dengan 3 role pengguna: Admin, Apoteker, dan Pelanggan.

## 📋 Fitur

### Admin
- Dashboard dengan statistik (total obat, penjualan, pendapatan, obat kadaluarsa)
- Manajemen data obat (CRUD)
- Manajemen apoteker (CRUD)
- Manajemen supplier
- Lihat daftar pembelian obat
- Report penjualan obat
- Cari obat yang akan kadaluarsa

### Apoteker
- Dashboard dengan statistik
- Manajemen data obat (CRUD)
- Pencarian obat
- Tambah penjualan obat
- Histori penjualan
- Lihat dan hapus obat kadaluarsa

### Pelanggan
- Registrasi akun baru
- Login
- Lihat daftar obat
- Lihat detail obat
- Pembelian obat
- Riwayat pembelian

## 🛠️ Teknologi

- **Backend**: Laravel 11+
- **Frontend**: Bootstrap 5, Font Awesome, jQuery
- **Database**: MySQL (db_apotek)
- **Template**: Custom SB Admin style

## 📦 Instalasi

### 1. Clone atau gunakan repository yang ada
```bash
cd /workspace
```

### 2. Install dependencies
```bash
composer install
npm install
```

### 3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_apotek
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat database dan jalankan migration
```sql
CREATE DATABASE db_apotek;
```

Jalankan script SQL di `database/migrations/2024_01_01_000000_create_db_apotek_tables.sql`:
```bash
mysql -u root -p db_apotek < database/migrations/2024_01_01_000000_create_db_apotek_tables.sql
```

Atau gunakan phpMyAdmin untuk import file SQL tersebut.

### 6. Jalankan aplikasi
```bash
php artisan serve
```

Akses aplikasi di: http://localhost:8000

## 👤 Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@apotek.com | password |
| Apoteker | apoteker@apotek.com | password |

## 📁 Struktur Folder Utama

```
/workspace
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── AdminController.php
│   │   │   ├── ApotekerController.php
│   │   │   └── PelangganController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Medicine.php
│       ├── Supplier.php
│       ├── Purchase.php
│       └── Sale.php
├── database/
│   └── migrations/
│       └── 2024_01_01_000000_create_db_apotek_tables.sql
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── signup.blade.php
│       ├── admin/
│       │   └── dashboard.blade.php
│       ├── apoteker/
│       └── pelanggan/
├── routes/
│   └── web.php
└── public/
    ├── css/
    │   └── style.css
    └── js/
        └── main.js
```

## 🔐 Hak Akses

### Halaman yang memerlukan login:
- Semua halaman Admin
- Semua halaman Apoteker
- Pembelian obat (Pelanggan)

### Halaman publik:
- Login
- Signup (Registrasi Pelanggan)

## 📝 Catatan

- Pastikan ekstensi PHP yang diperlukan sudah terinstall (pdo_mysql, mbstring, dll)
- Untuk development, pastikan write permission pada folder storage dan bootstrap/cache
- Password default untuk demo adalah "password" (tanpa tanda kutip)

## 🚀 Development

Untuk development dengan hot reload:
```bash
npm run dev
```

Untuk build production:
```bash
npm run build
```

## 📄 License

MIT License
