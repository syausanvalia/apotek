@extends('layouts.app')

@section('title', 'Beli Obat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('pelanggan.medicines.show', $medicine->id) }}" class="btn btn-secondary mb-3">&laquo; Kembali</a>
            <h1 class="h3 mb-3 text-gray-800">Beli Obat</h1>
        </div>
    </div>

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

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Obat</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Nama Obat</th>
                            <td>{{ $medicine->name }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $medicine->category }}</td>
                        </tr>
                        <tr>
                            <th>Harga Satuan</th>
                            <td>Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Stok Tersedia</th>
                            <td>{{ $medicine->stock }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $medicine->description ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Form Pembelian</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pelanggan.sales.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="medicine_id" value="{{ $medicine->id }}">
                        
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah Beli</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" 
                                   min="1" max="{{ $medicine->stock }}" value="1" required>
                            <small class="text-muted">Maksimal: {{ $medicine->stock }}</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Harga</label>
                            <div class="form-control-plaintext fw-bold fs-4 text-success" id="total-price">
                                Rp {{ number_format($medicine->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg">Konfirmasi Pembelian</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('quantity').addEventListener('change', function() {
    const quantity = parseInt(this.value) || 0;
    const price = {{ $medicine->price }};
    const total = quantity * price;
    document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
});
</script>
@endpush
@endsection
