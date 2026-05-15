@extends('layouts.app')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold" style="color: #6c5ce7;">Stok Toko Saya (Approved)</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="row">
            @forelse($orders as $item)
            <div class="col-md-3 mb-4 text-center">
                <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 15px;">
                    <img src="{{ asset('storage/products/' . $item->product->image) }}" class="mb-3 mx-auto" style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px;">
                    <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                    <span class="badge bg-light text-success mb-2" style="font-size: 14px;">Stok: {{ $item->quantity }} Pcs</span>
                    <p class="text-muted small mb-0">Tersedia di katalog anda.</p>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada stok yang di-approve. Silakan order ke Admin.</p>
                <a href="/orders/create" class="btn btn-primary" style="background-color: #6c5ce7; border: none;">Belanja Sekarang</a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
