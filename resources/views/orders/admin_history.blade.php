@extends('layouts.app')

@section('content')

    {{-- Stats Banner --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 14px; background: linear-gradient(135deg,#6c5ce7,#a29bfe); color:white;">
                <div style="font-size:28px; font-weight:700;">{{ $totalOrders }}</div>
                <small class="opacity-85">Total Semua Order</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 14px; background: linear-gradient(135deg,#00b894,#55efc4); color:white;">
                <div style="font-size:28px; font-weight:700;">{{ $totalApproved }}</div>
                <small class="opacity-85">Sudah Disetujui</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 14px; background: linear-gradient(135deg,#fdcb6e,#e17055); color:white;">
                <div style="font-size:28px; font-weight:700;">{{ $totalPending }}</div>
                <small class="opacity-85">Menunggu Approve</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 14px; background: linear-gradient(135deg,#0984e3,#74b9ff); color:white;">
                <div style="font-size:28px; font-weight:700;">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
                <small class="opacity-85">Total Nilai Order Approved</small>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="mb-0 fw-bold" style="color:#6c5ce7;">📦 History Semua Order</h5>
                <small class="text-muted">Seluruh transaksi order dari semua merchant</small>
            </div>
            {{-- Filter Form --}}
            <form method="GET" action="/orders/history" class="d-flex gap-2 align-items-center flex-wrap">
                <select name="merchant" class="form-select form-select-sm" style="border-radius:8px; min-width:160px;">
                    <option value="">Semua Merchant</option>
                    @foreach($merchants as $m)
                        <option value="{{ $m->id }}" {{ request('merchant') == $m->id ? 'selected' : '' }}>
                            {{ $m->name }}
                        </option>
                    @endforeach
                </select>
                <select name="status" class="form-select form-select-sm" style="border-radius:8px; min-width:130px;">
                    <option value="">Semua Status</option>
                    <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary px-3" style="border-radius:8px; background:#6c5ce7; border:none;">Filter</button>
                @if(request('merchant') || request('status'))
                    <a href="/orders/history" class="btn btn-sm btn-light px-3" style="border-radius:8px;">Reset</a>
                @endif
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Merchant</th>
                            <th>Produk</th>
                            <th>Foto</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $key => $item)
                            <tr>
                                <td class="ps-4 text-muted">{{ $orders->firstItem() + $key }}</td>
                                <td>
                                    <div class="fw-bold" style="font-size:14px;">{{ $item->user->name ?? '-' }}</div>
                                    <small class="text-muted">{{ $item->user->email ?? '' }}</small>
                                </td>
                                <td class="fw-bold">{{ $item->product->name ?? 'Produk dihapus' }}</td>
                                <td>
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/products/' . $item->product->image) }}"
                                            style="width:48px; height:48px; object-fit:cover; border-radius:8px;">
                                    @else
                                        <div style="width:48px;height:48px;border-radius:8px;background:#f1f0ff;display:flex;align-items:center;justify-content:center;">
                                            <span style="font-size:20px;">📦</span>
                                        </div>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $item->quantity }} Pcs</span></td>
                                <td class="text-muted small">
                                    {{ $item->product ? 'Rp ' . number_format($item->product->price, 0, ',', '.') : '-' }}
                                </td>
                                <td class="fw-bold text-success">
                                    {{ $item->product ? 'Rp ' . number_format($item->product->price * $item->quantity, 0, ',', '.') : '-' }}
                                </td>
                                <td>
                                    @if($item->status === 'approved')
                                        <span class="badge bg-success px-3 py-2" style="border-radius:20px;">✅ Approved</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-3 py-2" style="border-radius:20px;">⏳ Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size:13px;">{{ $item->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <div style="font-size:40px;">📭</div>
                                    <p class="mb-0 mt-2">Belum ada data order.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="p-4 border-top d-flex justify-content-center">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
