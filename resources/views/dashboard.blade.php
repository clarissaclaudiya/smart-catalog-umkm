@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Card Selamat Datang -->
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-sm"
                style="border-radius: 15px; background: linear-gradient(45deg, #6c5ce7, #a29bfe); color: white;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h2>
                        <p class="mb-0 opacity-75">
                            @if (Auth::user()->role == 'admin')
                                Anda masuk sebagai Admin. Kelola master data dan stok UMKM.
                            @else
                                Anda masuk sebagai Merchant. Kelola stok toko dan belanja barang.
                            @endif
                        </p>
                    </div>
                    <div class="text-end">
                        <img src="https://cdn-icons-png.flaticon.com/512/1532/1532642.png" alt="icon"
                            style="width: 80px; filter: brightness(0) invert(1);">
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->role == 'admin')
            <!-- Admin Stats -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px;">
                    <h6 class="text-muted small text-uppercase fw-bold">Total Merchant</h6>
                    <h2 class="fw-bold my-2" style="color: #6c5ce7;">{{ $totalMerchant }}</h2>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px;">
                    <h6 class="text-muted small text-uppercase fw-bold">Master Produk</h6>
                    <h2 class="fw-bold my-2" style="color: #6c5ce7;">{{ $totalProducts }}</h2>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px;">
                    <h6 class="text-muted small text-uppercase fw-bold">Order Pending</h6>
                    <h2 class="fw-bold my-2 text-danger">{{ $pendingOrders }}</h2>
                    <a href="/orders/admin" class="btn btn-sm btn-outline-danger mt-1">Lihat Order</a>
                </div>
            </div>
        @else
            <!-- Merchant Stats -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px;">
                    <h6 class="text-muted small text-uppercase fw-bold">Stok Toko Saya</h6>
                    <h2 class="fw-bold my-2" style="color: #6c5ce7;">{{ $myStock }}</h2>
                    <a href="/my-stock" class="btn btn-sm btn-primary mt-2"
                        style="background-color: #6c5ce7; border: none;">Buka Stok</a>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px;">
                    <h6 class="text-muted small text-uppercase fw-bold">Order Menunggu</h6>
                    <h2 class="fw-bold my-2 text-warning">{{ $pendingOrders }}</h2>
                    <a href="/orders/create" class="btn btn-sm btn-warning text-white mt-2"
                        style="border: none;">Belanja Lagi</a>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm p-4 text-center" style="border-radius: 15px;">
                <p class="mb-0 text-muted small">Smart-Catalog UMKM v1.0 - Sistem Manajemen Terintegrasi</p>
            </div>
        </div>
    </div>
@endsection