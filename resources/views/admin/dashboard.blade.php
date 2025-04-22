@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Vertical Tabs -->
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5>Menu Admin</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#data-barang" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                        <i class="fas fa-boxes me-2"></i> Data Barang
                    </a>
                    <a href="#riwayat-pembelian" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="fas fa-history me-2"></i> Riwayat Pembelian
                    </a>
                    <a href="#tambah-barang" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Barang
                    </a>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Data Barang -->
                <div class="tab-pane fade show active" id="data-barang">
                    @include('admin.partials.data_barang')
                </div>

                <!-- Riwayat Pembelian -->
                <div class="tab-pane fade" id="riwayat-pembelian">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <div class="d-flex justify-content-between">
                                <h5><i class="fas fa-history me-2"></i>Riwayat Pembelian</h5>
                                <input type="text" id="search-pembelian" class="form-control form-control-sm w-25" placeholder="Cari...">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Pembeli</th>
                                            <th>Barang</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pembelians as $pembelian)
                                        <tr>
                                            <td>{{ $pembelian->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <strong>{{ $pembelian->nama_pembeli }}</strong><br>
                                                <small>{{ $pembelian->no_hp }}</small>
                                            </td>
                                            <td>{{ $pembelian->indo->namabarang }}</td>
                                            <td>{{ $pembelian->jumlah_beli }}</td>
                                            <td>Rp {{ number_format($pembelian->total_harga, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $pembelian->status == 'completed' ? 'success' : 'warning' }}">
                                                    {{ $pembelian->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                                    data-bs-target="#detailPembelian{{ $pembelian->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $pembelians->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tambah Barang -->
                <div class="tab-pane fade" id="tambah-barang">
                    @include('admin.partials.tambah_barang')
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pembelian -->
@foreach($pembelians as $pembelian)
<div class="modal fade" id="detailPembelian{{ $pembelian->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detail Transaksi #{{ $pembelian->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Info Pembeli:</h6>
                        <p>
                            <strong>Nama:</strong> {{ $pembelian->nama_pembeli }}<br>
                            <strong>No HP:</strong> {{ $pembelian->no_hp }}<br>
                            <strong>Alamat:</strong> {{ $pembelian->alamat }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Detail Transaksi:</h6>
                        <p>
                            <strong>Barang:</strong> {{ $pembelian->indo->namabarang }}<br>
                            <strong>Harga Satuan:</strong> Rp {{ number_format($pembelian->harga_satuan, 2) }}<br>
                            <strong>Total:</strong> Rp {{ number_format($pembelian->total_harga, 2) }}
                        </p>
                    </div>
                </div>
                @if($pembelian->bukti_pembayaran)
                <div class="mt-3">
                    <h6>Bukti Pembayaran:</h6>
                    <img src="{{ asset('storage/'.$pembelian->bukti_pembayaran) }}" class="img-fluid" style="max-height: 200px;">
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                @if($pembelian->status == 'pending')
                <button class="btn btn-success">Konfirmasi Pembayaran</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Search functionality
    $('#search-pembelian').keyup(function() {
        const search = $(this).val().toLowerCase();
        $('tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(search) > -1)
        });
    });
});
</script>
@endsection