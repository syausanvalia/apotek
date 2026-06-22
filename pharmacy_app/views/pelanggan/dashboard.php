<?php
session_start();
require_once '../../config/helpers.php';
checkAuth();
checkRole(['pelanggan']);

require_once '../../config/database.php';
require_once '../../models/Medicine.php';

$pageTitle = 'Dashboard Pelanggan';

$database = new Database();
$db = $database->getConnection();
$medicineModel = new Medicine($db);

// Get available medicines
$medicines = $medicineModel->getAll();

ob_start();
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-3"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Pelanggan</h2>
            <p class="text-muted">Selamat datang, <?= htmlspecialchars($_SESSION['name']) ?>!</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card stat-card blue h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Obat Tersedia</h6>
                            <h3 class="mb-0"><?= $medicines->rowCount() ?> jenis</h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-pills fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card stat-card green h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Status Akun</h6>
                            <h3 class="mb-0">Aktif</h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-user-check fa-3x opacity-50"></i>
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
                        <div class="col-md-4 mb-3">
                            <a href="medicines.php" class="btn btn-outline-primary w-100">
                                <i class="fas fa-list me-2"></i>Lihat Semua Obat
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="purchase_history.php" class="btn btn-outline-success w-100">
                                <i class="fas fa-history me-2"></i>Histori Pembelian
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="../auth/logout.php" class="btn btn-outline-danger w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Medicines -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-star me-2"></i>Obat Tersedia
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php while ($medicine = $medicines->fetch(PDO::FETCH_ASSOC)): ?>
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($medicine['name']) ?></h5>
                                        <p class="card-text text-muted small"><?= htmlspecialchars(substr($medicine['description'], 0, 80)) ?>...</p>
                                        <p class="text-primary fw-bold"><?= formatRupiah($medicine['price']) ?></p>
                                        <p class="small text-muted">Stok: <?= $medicine['stock'] ?></p>
                                    </div>
                                    <div class="card-footer bg-white border-0">
                                        <a href="medicine_detail.php?id=<?= $medicine['id'] ?>" class="btn btn-sm btn-primary w-100">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
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
