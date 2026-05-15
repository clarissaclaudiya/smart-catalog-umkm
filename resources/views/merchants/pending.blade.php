@extends('layouts.app')

@section('content')
    <!-- Header Banner -->
    <div class="card border-0 shadow-sm mb-4"
        style="border-radius: 15px; background: linear-gradient(135deg, #f39c12, #f7b731); color: white;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">⏳ Persetujuan Merchant Baru</h4>
                <p class="mb-0 opacity-85">Review dan setujui merchant yang ingin bergabung bersama Smart-UMKM</p>
            </div>
            <div style="font-size: 48px;">🏪</div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold" style="color: #f39c12;">Daftar Permohonan Masuk</h5>
                <small class="text-muted">{{ $pendingMerchants->count() }} merchant menunggu persetujuan kamu</small>
            </div>
            <a href="/merchants" class="btn btn-sm btn-light" style="border-radius: 8px;">← Kembali ke Merchant Aktif</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
            @endif

            @forelse($pendingMerchants as $merchant)
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; border-left: 4px solid #f39c12 !important; border-left-width: 4px !important;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-1">
                                <div style="width:50px; height:50px; border-radius:50%; background: linear-gradient(135deg, #f39c12, #f7b731); display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:20px;">
                                    {{ strtoupper(substr($merchant->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <h6 class="fw-bold mb-0">{{ $merchant->name }}</h6>
                                <small class="text-muted">{{ $merchant->email }}</small>
                                <div class="mt-1">
                                    <span class="badge bg-warning text-dark px-3 py-1" style="border-radius: 20px; font-size: 11px;">
                                        ⏳ Menunggu Persetujuan
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted d-block">📅 Mendaftar pada:</small>
                                <span class="fw-bold">{{ $merchant->created_at->format('d M Y, H:i') }} WIB</span>
                                <div class="text-muted small mt-1">{{ $merchant->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="col-md-3 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <!-- Tombol Approve -->
                                    <form action="/merchants/approve/{{ $merchant->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success px-3"
                                            style="border-radius: 10px; font-weight: 600;"
                                            onclick="return confirm('Setujui merchant {{ $merchant->name }}?\nMerchant ini akan bisa login dan menggunakan platform.')">
                                            ✅ Setujui
                                        </button>
                                    </form>
                                    <!-- Tombol Reject -->
                                    <form action="/merchants/reject/{{ $merchant->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger px-3"
                                            style="border-radius: 10px; font-weight: 600;"
                                            onclick="return confirm('Tolak merchant {{ $merchant->name }}?\nMerchant ini tidak akan bisa login.')">
                                            ❌ Tolak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div style="font-size: 64px; margin-bottom: 16px;">✅</div>
                    <h5 class="fw-bold text-muted">Tidak ada permohonan masuk</h5>
                    <p class="text-muted">Semua merchant sudah diproses. Tidak ada yang perlu disetujui saat ini.</p>
                    <a href="/merchants" class="btn btn-sm btn-primary mt-2"
                        style="background-color: #6c5ce7; border: none; border-radius: 10px;">
                        Lihat Semua Merchant Aktif
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
