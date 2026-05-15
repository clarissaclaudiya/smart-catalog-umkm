@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12 text-center">
        <h4 class="fw-bold" style="color: #6c5ce7;">Katalog Belanja Admin</h4>
        <p class="text-muted">Pilih kategori untuk memfilter produk</p>
        
        <!-- Filter Kategori -->
        <div class="d-flex justify-content-center flex-wrap gap-2 mt-3">
            <a href="/orders/create" class="btn {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }} px-4 shadow-sm" style="border-radius: 20px; {{ !request('category') ? 'background-color: #6c5ce7; border: none;' : 'color: #6c5ce7; border-color: #6c5ce7;' }}">
                Semua Barang
            </a>
            @foreach($categories as $cat)
                <a href="/orders/create?category={{ $cat->id }}" 
                   class="btn {{ request('category') == $cat->id ? 'btn-primary' : 'btn-outline-primary' }} px-4 shadow-sm" 
                   style="border-radius: 20px; {{ request('category') == $cat->id ? 'background-color: #6c5ce7; border: none;' : 'color: #6c5ce7; border-color: #6c5ce7;' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-4">
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
        @endif

        <div class="row">
            @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; border: 1px solid #f0f0f0;">
                    <div class="position-relative">
                        <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                        <span class="position-absolute top-0 end-0 m-2 badge bg-danger shadow" style="font-size: 14px; padding: 8px 12px; border-radius: 10px; font-weight: 800;">
                            STOK: {{ $product->stock }}
                        </span>
                    </div>
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-1" style="font-size: 14px;">{{ $product->name }}</h6>
                        <p class="text-success small fw-bold mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        
                        <form action="/cart/store" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="d-flex gap-2">
                                <div class="input-group input-group-sm">
                                    <input type="number" name="quantity" class="form-control text-center fw-bold" value="1" min="1" max="{{ $product->stock }}" style="border-radius: 8px 0 0 8px; width: 60px;">
                                    <button type="submit" class="btn btn-primary" style="background-color: #6c5ce7; border: none; border-radius: 0 8px 8px 0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-cart-plus mb-1" viewBox="0 0 16 16">
                                            <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/5058/5058432.png" style="width: 80px; opacity: 0.3;">
                </div>
                <p class="text-muted">Tidak ada produk ditemukan di kategori ini.</p>
                <a href="/orders/create" class="btn btn-sm btn-link" style="color: #6c5ce7; text-decoration: none;">Lihat Semua Produk</a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
