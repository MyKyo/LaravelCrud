@extends('layouts.app')

@section('title', 'Beli Barang')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-shopping-cart me-2"></i>Form Pembelian
                        </h4>
                        <span class="badge bg-white text-primary fs-6">Stok: {{ $barang->jumlahbarang }}</span>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <!-- Product Info -->
                    <div class="product-info mb-4 p-4 bg-light rounded-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="text-primary">{{ $barang->namabarang }}</h3>
                                <div class="d-flex align-items-center mt-2">
                                    <span class="fs-4 fw-bold text-dark me-3">Rp {{ number_format($barang->harga, 2) }}</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-check-circle me-1"></i>Tersedia
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <div class="availability-indicator">
                                    <div class="progress" style="height: 8px;">
                                        @php
                                            $percentage = min(100, ($barang->jumlahbarang / ($barang->jumlahbarang + 10)) * 100);
                                        @endphp
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: {{ $percentage }}%" 
                                             aria-valuenow="{{ $percentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted">{{ $barang->jumlahbarang }} unit tersedia dari {{ $barang->jumlahbarang + 10 }} stok awal</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <h5 class="alert-heading">Terjadi Kesalahan!</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('indo.purchase', $barang->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="harga_satuan" value="{{ $barang->harga }}">

                        <div class="row g-4">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" 
                                           value="{{ old('nama_pembeli') }}" placeholder="Nama Lengkap" required>
                                    <label for="nama_pembeli">Nama Lengkap</label>
                                    <div class="invalid-feedback">Harap isi nama lengkap Anda</div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="tel" class="form-control" id="no_hp" name="no_hp" 
                                           value="{{ old('no_hp') }}" placeholder="Nomor HP/WhatsApp" required>
                                    <label for="no_hp">Nomor HP/WhatsApp</label>
                                    <div class="invalid-feedback">Harap isi nomor yang bisa dihubungi</div>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="alamat" name="alamat" 
                                              placeholder="Alamat Lengkap" style="height: 120px" required>{{ old('alamat') }}</textarea>
                                    <label for="alamat">Alamat Lengkap</label>
                                    <div class="invalid-feedback">Harap isi alamat pengiriman</div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary mb-3">
                                            <i class="fas fa-calculator me-2"></i>Detail Pembelian
                                        </h5>
                                        
                                        <div class="mb-3">
                                            <label for="jumlah_beli" class="form-label fw-bold">Jumlah Beli</label>
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary decrement" type="button">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" class="form-control text-center" id="jumlah_beli" 
                                                       name="jumlah_beli" min="1" max="{{ $barang->jumlahbarang }}" 
                                                       value="{{ old('jumlah_beli', 1) }}" required>
                                                <button class="btn btn-outline-secondary increment" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">Maksimal: {{ $barang->jumlahbarang }} unit</small>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Total Pembayaran</label>
                                            <div class="bg-light p-3 rounded-2">
                                                <h3 class="text-success mb-0" id="total_harga">
                                                    Rp {{ number_format($barang->harga, 2) }}
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="metode_pembayaran" class="form-label fw-bold">Metode Pembayaran</label>
                                            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                                <option value="" disabled selected>Pilih Metode</option>
                                                <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>
                                                    <i class="fas fa-university me-2"></i>Transfer Bank
                                                </option>
                                                <option value="cod" {{ old('metode_pembayaran') == 'cod' ? 'selected' : '' }}>
                                                    <i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery (COD)
                                                </option>
                                                <option value="e-wallet" {{ old('metode_pembayaran') == 'e-wallet' ? 'selected' : '' }}>
                                                    <i class="fas fa-wallet me-2"></i>E-Wallet
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="{{ route('indo.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-credit-card me-2"></i>Proses Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Quantity controls
    const jumlahInput = document.getElementById('jumlah_beli');
    const decrementBtn = document.querySelector('.decrement');
    const incrementBtn = document.querySelector('.increment');
    const totalDisplay = document.getElementById('total_harga');
    const hargaSatuan = parseFloat({{ $barang->harga }}); // Ensure this is correct
    const maxStock = {{ $barang->jumlahbarang }};

    function formatRupiah(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function updateTotal() {
        const jumlah = parseInt(jumlahInput.value) || 1;
        const total = hargaSatuan * jumlah;
        totalDisplay.textContent = formatRupiah(total);
        
        // Toggle button states
        decrementBtn.disabled = jumlah <= 1;
        incrementBtn.disabled = jumlah >= maxStock;
    }

    decrementBtn.addEventListener('click', () => {
        let value = parseInt(jumlahInput.value);
        if (value > 1) {
            jumlahInput.value = value - 1;
            updateTotal();
        }
    });

    incrementBtn.addEventListener('click', () => {
        let value = parseInt(jumlahInput.value);
        if (value < maxStock) {
            jumlahInput.value = value + 1;
            updateTotal();
        }
    });

    jumlahInput.addEventListener('input', () => {
        let value = parseInt(jumlahInput.value);
        if (isNaN(value) || value < 1) {
            jumlahInput.value = 1;
        } else if (value > maxStock) {
            jumlahInput.value = maxStock;
        }
        updateTotal();
    });

    // Initialize
    updateTotal();
    
    // Debug output
    console.log("Harga Satuan:", hargaSatuan);
    console.log("Initial Quantity:", jumlahInput.value);
});
</script>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
    }
    
    .product-info {
        border-left: 4px solid #3a7bd5;
        background-color: rgba(58, 123, 213, 0.05);
    }
    
    .form-floating label {
        color: #6c757d;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3a7bd5;
        box-shadow: 0 0 0 0.25rem rgba(58, 123, 213, 0.25);
    }
    
    .btn-primary {
        background-color: #3a7bd5;
        border-color: #3a7bd5;
    }
    
    .btn-primary:hover {
        background-color: #2c5fb3;
        border-color: #2c5fb3;
    }
    
    .btn-outline-secondary:hover {
        color: #fff;
        background-color: #6c757d;
    }
    
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .progress {
        border-radius: 10px;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
    }
</style>
@endsection