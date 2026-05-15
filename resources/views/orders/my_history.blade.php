@extends('layouts.app')

@section('content')

    {{-- Stats --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:14px; background:linear-gradient(135deg,#6c5ce7,#a29bfe); color:white;">
                <div style="font-size:28px; font-weight:700;">{{ $totalApproved }}</div>
                <small class="opacity-85">Order Disetujui</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:14px; background:linear-gradient(135deg,#fdcb6e,#e17055); color:white;">
                <div style="font-size:28px; font-weight:700;">{{ $totalPending }}</div>
                <small class="opacity-85">Menunggu Approve</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:14px; background:linear-gradient(135deg,#00b894,#55efc4); color:white;">
                <div style="font-size:28px; font-weight:700;">Rp {{ number_format($totalSpent,0,',','.') }}</div>
                <small class="opacity-85">Total Nilai Stok Diterima</small>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm" style="border-radius:15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold" style="color:#6c5ce7;">🧾 History Order Saya</h5>
                <small class="text-muted">Semua transaksi order yang pernah kamu buat</small>
            </div>
            <a href="/orders/create" class="btn btn-sm btn-primary px-3"
                style="border-radius:8px; background:#6c5ce7; border:none;">
                + Order Baru
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Produk</th>
                            <th>Foto</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                            <th>Total Nilai</th>
                            <th>Status</th>
                            <th>Tanggal Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $key => $item)
                            <tr>
                                <td class="ps-4 text-muted">{{ $key + 1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ $item->product->name ?? 'Produk dihapus' }}</div>
                                    @if($item->product)
                                        <small class="text-muted">
                                            {{ $item->product->category->name ?? '' }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/products/' . $item->product->image) }}"
                                            style="width:52px; height:52px; object-fit:cover; border-radius:10px; border:2px solid #f1f0ff;">
                                    @else
                                        <div style="width:52px;height:52px;border-radius:10px;background:#f1f0ff;display:flex;align-items:center;justify-content:center;">
                                            <span style="font-size:22px;">📦</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-bold">{{ $item->quantity }} Pcs</span>
                                </td>
                                <td class="text-muted small">
                                    {{ $item->product ? 'Rp ' . number_format($item->product->price, 0, ',', '.') : '-' }}
                                </td>
                                <td class="fw-bold" style="color:#6c5ce7;">
                                    {{ $item->product ? 'Rp ' . number_format($item->product->price * $item->quantity, 0, ',', '.') : '-' }}
                                </td>
                                <td>
                                    @if($item->status === 'approved')
                                        <span class="badge bg-success px-3 py-2" style="border-radius:20px; font-size:12px;">
                                            ✅ Disetujui
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark px-3 py-2" style="border-radius:20px; font-size:12px;">
                                            ⏳ Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size:13px;">{{ $item->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                                    <div class="text-muted" style="font-size:11px;">{{ $item->created_at->diffForHumans() }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div style="font-size:48px;">📭</div>
                                    <p class="text-muted mt-2 mb-0">Kamu belum pernah membuat order.</p>
                                    <a href="/orders/create" class="btn btn-sm btn-primary mt-3"
                                        style="background:#6c5ce7; border:none; border-radius:8px;">
                                        Mulai Order Sekarang
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
