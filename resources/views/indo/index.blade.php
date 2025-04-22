@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-boxes me-2"></i>Daftar Barang Tersedia
                    </h5>
                    <form action="{{ route('indo.index') }}" method="GET" class="input-group" style="width: 300px;">
                        <input type="text" class="form-control" name="search" placeholder="Cari barang..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="20%">Nama</th>
                                <th width="25%">Barang</th>
                                <th width="20%">Harga</th>
                                <th width="15%">Stok</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($indo as $item)
                            <tr>
                                <td>{{ $item->nama ?? '-' }}</td>
                                <td>{{ $item->namabarang ?? '-' }}</td>
                                <td>Rp {{ isset($item->harga) ? number_format($item->harga, 2) : '0' }}</td>
                                <td>
                                    @if(($item->jumlahbarang ?? 0) > 5)
                                        <span class="badge bg-success">{{ $item->jumlahbarang }} tersedia</span>
                                    @elseif(($item->jumlahbarang ?? 0) > 0)
                                        <span class="badge bg-warning text-dark">Hampir habis</span>
                                    @else
                                        <span class="badge bg-danger">Stok kosong</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(($item->jumlahbarang ?? 0) > 0)
                                    <a href="{{ route('indo.buy', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-cart-plus me-1"></i> Beli
                                    </a>
                                    @else
                                    <button class="btn btn-sm btn-secondary" disabled>
                                        <i class="fas fa-times-circle me-1"></i> Stok Habis
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-box-open fa-2x mb-2 text-muted"></i>
                                    <p class="text-muted">Tidak ada barang tersedia saat ini</p>
                                    <a href="{{ route('indo.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="fas fa-sync-alt me-1"></i> Refresh
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($indo->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $indo->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection