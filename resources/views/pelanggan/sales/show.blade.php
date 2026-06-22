@extends('layouts.app')

@section('title', 'Detail Pembelian')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('pelanggan.purchase-history') }}" class="btn btn-secondary mb-3">&laquo; Kembali</a>
            <h1 class="h3 mb-3 text-gray-800">Detail Pembelian</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pembelian</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Nomor Transaksi</th>
                            <td>#{{ $sale->id }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pembelian</th>
                            <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y, H:i') }}</td>
                        </tr>
                        @if($sale->medicine)
                        <tr>
                            <th>Nama Obat</th>
                            <td>{{ $sale->medicine->name }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $sale->medicine->category }}</td>
                        </tr>
                        @else
                        <tr>
                            <th>Nama Obat</th>
                            <td><em>Obat telah dihapus dari sistem</em></td>
                        </tr>
                        @endif
                        <tr>
                            <th>Jumlah Beli</th>
                            <td>{{ $sale->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Harga Satuan</th>
                            <td>Rp {{ number_format($sale->total_price / $sale->quantity, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td class="fw-bold text-success">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="badge bg-success">Selesai</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Ringkasan</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">Terima kasih telah melakukan pembelian di apotek kami.</p>
                    <p class="mb-0 small text-muted">Jika ada pertanyaan mengenai pembelian ini, silakan hubungi customer service kami.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
