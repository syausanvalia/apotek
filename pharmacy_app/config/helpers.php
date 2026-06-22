<?php
session_start();

// Cek apakah user sudah login
function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../auth/login.php");
        exit();
    }
}

// Cek role user
function checkRole($allowedRoles) {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowedRoles)) {
        header("Location: ../auth/login.php");
        exit();
    }
}

// Format rupiah
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Redirect berdasarkan role
function redirectByRole() {
    if (!isset($_SESSION['role'])) {
        header("Location: login.php");
        exit();
    }

    switch($_SESSION['role']) {
        case 'admin':
            header("Location: ../admin/dashboard.php");
            break;
        case 'apoteker':
            header("Location: ../apoteker/dashboard.php");
            break;
        case 'pelanggan':
            header("Location: ../pelanggan/dashboard.php");
            break;
        default:
            header("Location: login.php");
    }
    exit();
}
?>
