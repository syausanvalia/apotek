<?php
session_start();
require_once '../../config/helpers.php';
checkAuth();
checkRole(['admin']);

require_once '../../config/database.php';
require_once '../../models/Sale.php';
require_once '../../models/Medicine.php';

$pageTitle = 'Dashboard Admin';

$database = new Database();
$db = $database->getConnection();
$saleModel = new Sale($db);
$medicineModel = new Medicine($db);

// Get statistics
$totalSales = $saleModel->getTotalSales();
$totalTransactions = $saleModel->getTotalTransactions();
$totalMedicinesSold = $medicineModel->getTotalSold();

ob_start();
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-3"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</h2>
            <p class="text-muted">Selamat datang, <?= htmlspecialchars($_SESSION['name']) ?>!</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card stat-card blue h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Penjualan</h6>
                            <h3 class="mb-0"><?= formatRupiah($totalSales) ?></h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-chart-line fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card stat-card green h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Transaksi</h6>
                            <h3 class="mb-0"><?= number_format($totalTransactions) ?></h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card stat-card orange h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Obat Terjual</h6>
                            <h3 class="mb-0"><?= number_format($totalMedicinesSold) ?> unit</h3>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-pills fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="medicines.php" class="btn btn-outline-primary w-100">
                                <i class="fas fa-pills me-2"></i>Lihat Obat
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="apoteker.php" class="btn btn-outline-success w-100">
                                <i class="fas fa-user-nurse me-2"></i>Kelola Apoteker
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="suppliers.php" class="btn btn-outline-info w-100">
                                <i class="fas fa-truck me-2"></i>Kelola Supplier
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="sales_report.php" class="btn btn-outline-warning w-100">
                                <i class="fas fa-file-alt me-2"></i>Report Penjualan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../layouts/main.php';
?>
