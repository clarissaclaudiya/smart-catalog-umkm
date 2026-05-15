@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold" style="color: #6c5ce7;">Keranjang Belanja</h5>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger border-0 small mb-3">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success border-0 small mb-3">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="small text-muted text-uppercase">
                                <th>Produk</th>
                                <th>Harga</th>
                                <th style="width: 150px;">Jumlah</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @forelse($cartItems as $item)
                            @php $subtotal = $item->product->price * $item->quantity; $total += $subtotal; @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/products/' . $item->product->image) }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0 fw-bold small">{{ $item->product->name }}</h6>
                                            <small class="text-muted">Stok: {{ $item->product->stock }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="small">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                <td>
                                    <form action="/cart/update/{{ $item->id }}" method="POST">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="quantity" class="form-control text-center fw-bold" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" onchange="this.form.submit()">
                                        </div>
                                    </form>
                                </td>
                                <td class="small fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td>
                                    <form action="/cart/delete/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-danger p-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" style="width: 60px; opacity: 0.3;" class="mb-2 d-block mx-auto">
                                    <p class="text-muted">Keranjang masih kosong.</p>
                                    <a href="/orders/create" class="btn btn-sm btn-primary" style="background-color: #6c5ce7; border: none; border-radius: 8px;">Mulai Belanja</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold" style="color: #6c5ce7;">Ringkasan Checkout</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Total Tagihan</span>
                    <h5 class="fw-bold" style="color: #6c5ce7;">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</h5>
                </div>
                <hr>
                <p class="small text-muted mb-4">Setelah checkout, pesanan akan diteruskan ke Admin untuk disetujui sebelum masuk ke stok toko kamu.</p>
                
                <form action="/cart/checkout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm {{ $cartItems->isEmpty() ? 'disabled' : '' }}" style="background-color: #6c5ce7; border: none; border-radius: 12px;">
                        Checkout Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
