@extends('layouts.app')

@section('title', 'Riwayat Pembelian')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3 text-gray-800">Riwayat Pembelian Obat</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($sales->count() > 0)
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Obat</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $index => $sale)
                                <tr>
                                    <td>{{ $sales->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y, H:i') }}</td>
                                    <td>{{ $sale->medicine ? $sale->medicine->name : 'Obat dihapus' }}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-success">Selesai</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pelanggan.sales.show', $sale->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $sales->links() }}
            </div>
            @else
            <div class="alert alert-info">
                Anda belum memiliki riwayat pembelian.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
