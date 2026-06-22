@extends('layouts.app')

@section('title', 'Dashboard Admin - Apotek App')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h2>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Obat</h6>
                        <h2 class="mb-0">{{ number_format($totalMedicines) }}</h2>
                    </div>
                    <i class="fas fa-pills fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Penjualan</h6>
                        <h2 class="mb-0">{{ number_format($totalSales) }}</h2>
                    </div>
                    <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Pendapatan</h6>
                        <h2 class="mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                    </div>
                    <i class="fas fa-chart-line fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Obat Kadaluarsa</h6>
                        <h2 class="mb-0">{{ number_format($expiredMedicines) }}</h2>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Sales -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-history"></i> Penjualan Terakhir</h5>
            </div>
            <div class="card-body">
                @if($recentSales->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Obat</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSales as $sale)
                                    <tr>
                                        <td>{{ $sale->sale_date->format('d/m/Y H:i') }}</td>
                                        <td>{{ $sale->user->name }}</td>
                                        <td>{{ $sale->medicine->name }}</td>
                                        <td>{{ $sale->quantity }}</td>
                                        <td>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada data penjualan.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
