@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3 text-gray-800">Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="text-muted">Temukan obat yang Anda butuhkan dengan mudah dan cepat.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Obat Tersedia</div>
                    <div class="h5 mb-0">{{ $totalMedicines ?? 0 }} Jenis</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Riwayat Pembelian</div>
                    <div class="h5 mb-0">{{ $totalPurchases ?? 0 }} Transaksi</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Status Akun</div>
                    <div class="h5 mb-0">Aktif</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Medicines -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Obat Tersedia</h6>
                    <a href="{{ route('pelanggan.medicines') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @if(isset($medicines) && $medicines->count() > 0)
                        <div class="row">
                            @foreach($medicines as $medicine)
                                <div class="col-md-3 col-sm-6 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $medicine->name }}</h6>
                                            <p class="card-text text-muted small">{{ Str::limit($medicine->description, 50) }}</p>
                                            <p class="card-text">
                                                <strong class="text-success">Rp {{ number_format($medicine->price, 0, ',', '.') }}</strong>
                                            </p>
                                            <p class="card-text small">
                                                Stok: <span class="badge bg-info">{{ $medicine->stock }}</span>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-white border-top-0">
                                            <a href="{{ route('pelanggan.medicines.show', $medicine->id) }}" class="btn btn-sm btn-outline-primary w-100">Lihat Detail</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">Belum ada obat tersedia saat ini.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
