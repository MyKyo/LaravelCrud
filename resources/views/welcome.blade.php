@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Selamat Datang di Indo App</h4>
                </div>
                <div class="card-body text-center py-5">
                    <h2><i class="fas fa-store-alt text-primary"></i></h2>
                    <h3 class="mt-3">Sistem Manajemen Barang & Pembelian</h3>
                    <p class="lead mt-3">
                        Aplikasi untuk mengelola data barang dan transaksi pembelian
                    </p>
                    <a href="{{ route('indo.index') }}" class="btn btn-primary btn-lg mt-4">
                        <i class="fas fa-shopping-basket me-2"></i> Mulai Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection