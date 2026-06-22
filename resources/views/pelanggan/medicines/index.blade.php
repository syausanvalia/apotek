@extends('layouts.app')

@section('title', 'Daftar Obat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3 text-gray-800">Daftar Obat Tersedia</h1>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('pelanggan.medicines.search') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari obat..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
    </div>

    <!-- Medicines Grid -->
    <div class="row">
        @forelse($medicines as $medicine)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $medicine->name }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($medicine->description, 80) }}</p>
                    <p class="card-text">
                        <strong>Kategori:</strong> {{ $medicine->category }}<br>
                        <strong>Harga:</strong> Rp {{ number_format($medicine->price, 0, ',', '.') }}<br>
                        <strong>Stok:</strong> {{ $medicine->stock }}
                    </p>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="{{ route('pelanggan.medicines.show', $medicine->id) }}" class="btn btn-primary btn-sm w-100">Lihat Detail</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">Belum ada obat tersedia.</div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            {{ $medicines->links() }}
        </div>
    </div>
</div>
@endsection
