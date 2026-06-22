<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle : 'Apotek System' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../public/css/style.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #1a252f 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255,255,255,0.1);
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .sidebar-brand {
            padding: 20px;
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .main-content {
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
            border-radius: 12px 12px 0 0 !important;
            padding: 20px;
            font-weight: 600;
        }
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            background-color: #fff;
        }
        .stat-card {
            border-left: 4px solid;
        }
        .stat-card.blue { border-left-color: #3498db; }
        .stat-card.green { border-left-color: #27ae60; }
        .stat-card.orange { border-left-color: #f39c12; }
        .stat-card.red { border-left-color: #e74c3c; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse" id="sidebarMenu">
                <div class="sidebar-brand">
                    <i class="fas fa-clinic-medical me-2"></i>
                    <?= ucfirst($_SESSION['role'] ?? 'Apotek') ?>
                </div>
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <?php if ($_SESSION['role'] == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'medicines.php' ? 'active' : '' ?>" href="medicines.php">
                                    <i class="fas fa-pills"></i> Daftar Obat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'apoteker.php' ? 'active' : '' ?>" href="apoteker.php">
                                    <i class="fas fa-user-nurse"></i> Daftar Apoteker
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'suppliers.php' ? 'active' : '' ?>" href="suppliers.php">
                                    <i class="fas fa-truck"></i> Daftar Supplier
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'purchases.php' ? 'active' : '' ?>" href="purchases.php">
                                    <i class="fas fa-shopping-cart"></i> Pembelian Obat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'sales_report.php' ? 'active' : '' ?>" href="sales_report.php">
                                    <i class="fas fa-chart-line"></i> Report Penjualan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'expired.php' ? 'active' : '' ?>" href="expired.php">
                                    <i class="fas fa-exclamation-triangle"></i> Obat Kadaluarsa
                                </a>
                            </li>
                        <?php elseif ($_SESSION['role'] == 'apoteker'): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'medicines.php' ? 'active' : '' ?>" href="medicines.php">
                                    <i class="fas fa-pills"></i> Data Obat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'add_medicine.php' ? 'active' : '' ?>" href="add_medicine.php">
                                    <i class="fas fa-plus-circle"></i> Tambah Obat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'sales.php' ? 'active' : '' ?>" href="sales.php">
                                    <i class="fas fa-cash-register"></i> Penjualan Obat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'sale_history.php' ? 'active' : '' ?>" href="sale_history.php">
                                    <i class="fas fa-history"></i> Histori Penjualan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'search.php' ? 'active' : '' ?>" href="search.php">
                                    <i class="fas fa-search"></i> Cari Obat
                                </a>
                            </li>
                        <?php elseif ($_SESSION['role'] == 'pelanggan'): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'medicines.php' ? 'active' : '' ?>" href="medicines.php">
                                    <i class="fas fa-pills"></i> Lihat Obat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'purchase_history.php' ? 'active' : '' ?>" href="purchase_history.php">
                                    <i class="fas fa-receipt"></i> Histori Pembelian
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    
                    <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="../auth/logout.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light mb-4 rounded">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-2"></i>
                                        <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="../auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['message_type'] ?? 'info' ?> alert-dismissible fade show" role="alert">
                        <?= $_SESSION['message'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
                <?php endif; ?>

                <?= $content ?? '' ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <!-- Custom JS -->
    <script src="../public/js/main.js"></script>
</body>
</html>
