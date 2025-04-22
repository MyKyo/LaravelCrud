<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-box me-2"></i>Daftar Barang</h5>
            <a href="{{ route('indo.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Tambah Barang
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($indo as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->namabarang }}</td>
                        <td>Rp {{ number_format($item->harga, 2) }}</td>
                        <td>{{ $item->jumlahbarang }}</td>
                        <td>
                            <a href="{{ route('indo.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('indo.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <a href="{{ route('indo.buy', $item->id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>