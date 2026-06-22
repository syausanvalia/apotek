@extends('layouts.app')

@section('title', 'Detail Obat')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('pelanggan.medicines') }}" class="btn btn-secondary mb-3">&laquo; Kembali</a>
            <h1 class="h3 mb-3 text-gray-800">{{ $medicine->name }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Informasi Obat</h5>
                    <hr>
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
                            <th>Harga</th>
                            <td>Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Stok Tersedia</th>
                            <td>
                                <span class="badge {{ $medicine->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $medicine->stock }} {{ $medicine->stock > 0 ? 'tersedia' : 'habis' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Kadaluarsa</th>
                            <td>{{ $medicine->expiry_date ? \Carbon\Carbon::parse($medicine->expiry_date)->format('d M Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge {{ $medicine->status === 'available' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($medicine->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $medicine->description ?? '-' }}</td>
                        </tr>
                        @if($medicine->supplier)
                        <tr>
                            <th>Supplier</th>
                            <td>{{ $medicine->supplier->name }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Beli Obat</h5>
                    <hr>
                    @if($medicine->status === 'available' && $medicine->stock > 0)
                        <form action="{{ route('pelanggan.sales.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="medicine_id" value="{{ $medicine->id }}">
                            
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" 
                                       min="1" max="{{ $medicine->stock }}" value="1" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Total Harga</label>
                                <div class="form-control-plaintext fw-bold" id="total-price">
                                    Rp {{ number_format($medicine->price, 0, ',', '.') }}
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Beli Sekarang</button>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            Obat ini sedang tidak tersedia untuk dibeli.
                        </div>
                    @endif
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
