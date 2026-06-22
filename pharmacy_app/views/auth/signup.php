<?php
session_start();

require_once '../config/database.php';
require_once '../models/User.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    // Validasi
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Semua field wajib diisi!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak sama!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        $database = new Database();
        $db = $database->getConnection();
        $userModel = new User($db);

        if ($userModel->register($name, $email, $password, $phone, $address)) {
            $success = 'Pendaftaran berhasil! Silakan login.';
        } else {
            $error = 'Email sudah terdaftar atau terjadi kesalahan!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Apotek System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }
        .signup-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }
        .signup-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .signup-body {
            padding: 40px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-signup {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .btn-signup:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="signup-card">
        <div class="signup-header">
            <i class="fas fa-user-plus fa-3x mb-3"></i>
            <h3>Daftar Akun Baru</h3>
            <p class="mb-0">Bergabunglah sebagai pelanggan</p>
        </div>
        <div class="signup-body">
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-2"></i>Nama Lengkap
                    </label>
                    <input type="text" class="form-control" id="name" name="name" required 
                           placeholder="Masukkan nama lengkap Anda" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i>Email
                    </label>
                    <input type="email" class="form-control" id="email" name="email" required 
                           placeholder="Masukkan email Anda" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone me-2"></i>Nomor Telepon
                    </label>
                    <input type="text" class="form-control" id="phone" name="phone" 
                           placeholder="Masukkan nomor telepon Anda" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">
                        <i class="fas fa-map-marker-alt me-2"></i>Alamat
                    </label>
                    <textarea class="form-control" id="address" name="address" rows="2" 
                              placeholder="Masukkan alamat Anda"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2"></i>Password
                    </label>
                    <input type="password" class="form-control" id="password" name="password" required 
                           placeholder="Minimal 6 karakter">
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="form-label">
                        <i class="fas fa-lock me-2"></i>Konfirmasi Password
                    </label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required 
                           placeholder="Ulangi password Anda">
                </div>
                <button type="submit" class="btn btn-primary btn-signup w-100">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </button>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <p class="mb-0">Sudah punya akun?</p>
                <a href="login.php" class="text-decoration-none">Login di sini</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
