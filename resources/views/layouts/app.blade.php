<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Apotek')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="bg-light">
    @auth
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar bg-dark">
        <div class="sidebar-header bg-primary">
            <h4><i class="fas fa-clinic-medical"></i> Apotek App</h4>
        </div>
        
        <ul class="list-unstyled components">
            @if(auth()->user()->isAdmin())
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="#medicineSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-pills"></i> Obat
                    </a>
                    <ul class="collapse list-unstyled" id="medicineSubmenu">
                        <li><a href="{{ route('admin.medicines') }}">Daftar Obat</a></li>
                        <li><a href="{{ route('admin.medicines.create') }}">Tambah Obat</a></li>
                        <li><a href="{{ route('admin.expired-medicines') }}">Obat Kadaluarsa</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#apotekerSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-user-md"></i> Apoteker
                    </a>
                    <ul class="collapse list-unstyled" id="apotekerSubmenu">
                        <li><a href="{{ route('admin.apotekers') }}">Daftar Apoteker</a></li>
                        <li><a href="{{ route('admin.apotekers.create') }}">Tambah Apoteker</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.suppliers') }}">
                        <i class="fas fa-truck"></i> Supplier
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.purchases') }}">
                        <i class="fas fa-shopping-cart"></i> Pembelian
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.sales-report') }}">
                        <i class="fas fa-chart-line"></i> Report Penjualan
                    </a>
                </li>
            @elseif(auth()->user()->isApoteker())
                <li>
                    <a href="{{ route('apoteker.dashboard') }}" class="{{ request()->routeIs('apoteker.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="#medicineSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-pills"></i> Obat
                    </a>
                    <ul class="collapse list-unstyled" id="medicineSubmenu">
                        <li><a href="{{ route('apoteker.medicines') }}">Daftar Obat</a></li>
                        <li><a href="{{ route('apoteker.medicines.create') }}">Tambah Obat</a></li>
                        <li><a href="{{ route('apoteker.expired-medicines') }}">Obat Kadaluarsa</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#salesSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-cash-register"></i> Penjualan
                    </a>
                    <ul class="collapse list-unstyled" id="salesSubmenu">
                        <li><a href="{{ route('apoteker.sales-history') }}">Histori Penjualan</a></li>
                        <li><a href="{{ route('apoteker.sales.create') }}">Tambah Penjualan</a></li>
                    </ul>
                </li>
            @else
                <li>
                    <a href="{{ route('pelanggan.dashboard') }}" class="{{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('pelanggan.medicines') }}">
                        <i class="fas fa-pills"></i> Daftar Obat
                    </a>
                </li>
                <li>
                    <a href="{{ route('pelanggan.purchase-history') }}">
                        <i class="fas fa-history"></i> Riwayat Pembelian
                    </a>
                </li>
            @endif
        </ul>
    </nav>

    <!-- Page Content -->
    <div id="content" class="content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-outline-primary">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3">Halo, {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    @else
    <!-- Guest Layout -->
    <div class="container">
        @yield('content')
    </div>
    @endauth

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
