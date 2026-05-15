@extends('layouts.app')

@section('content')

    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4"
        style="border-radius: 15px; background: linear-gradient(135deg, #e17055, #d63031); color: white;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">⛔ Merchant Nonaktif</h4>
                <p class="mb-0 opacity-85">Merchant yang pernah aktif kerjasama namun telah dinonaktifkan oleh admin</p>
            </div>
            <div style="font-size: 48px;">🏪</div>
        </div>
    </div>

    {{-- Daftar Merchant yang Sedang Nonaktif --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold" style="color: #e17055;">Daftar Akun Nonaktif</h5>
                <small class="text-muted">{{ $suspendedMerchants->count() }} merchant saat ini dinonaktifkan</small>
            </div>
            <a href="/merchants" class="btn btn-sm btn-light" style="border-radius: 8px;">← Merchant Aktif</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif

            @forelse($suspendedMerchants as $merchant)
                <div class="card border-0 shadow-sm mb-3"
                    style="border-radius: 12px; border-left: 4px solid #e17055 !important;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-1">
                                <div style="width:46px; height:46px; border-radius:50%; background: linear-gradient(135deg, #e17055, #fab1a0); display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:18px;">
                                    {{ strtoupper(substr($merchant->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6 class="fw-bold mb-0">{{ $merchant->name }}</h6>
                                <small class="text-muted">{{ $merchant->email }}</small>
                                <div class="mt-1">
                                    <span class="badge bg-secondary px-2 py-1" style="border-radius: 20px; font-size: 11px;">
                                        ⛔ Nonaktif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">📅 Bergabung:</small>
                                <span class="fw-bold small">{{ $merchant->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="col-md-3 text-end">
                                <form action="/merchants/reactivate/{{ $merchant->id }}" method="POST"
                                    onsubmit="return confirm('Aktifkan kembali merchant {{ addslashes($merchant->name) }}?\nMerchant ini akan langsung bisa login kembali.')">
                                    @csrf
                                    <button type="submit" class="btn btn-success px-3"
                                        style="border-radius: 10px; font-weight: 600;">
                                        🔄 Aktifkan Kembali
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <div style="font-size: 48px; margin-bottom: 12px;">✅</div>
                    <p class="text-muted mb-0">Tidak ada merchant yang sedang dinonaktifkan.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- History Log Nonaktif (hanya suspended & reactivated) --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold" style="color: #636e72;">📋 Riwayat Penonaktifan</h5>
            <small class="text-muted">Log semua aksi nonaktif dan reaktivasi yang pernah dilakukan admin</small>
        </div>
        <div class="card-body p-0">
            @if($suspensionLogs->isEmpty())
                <div class="text-center py-4">
                    <p class="text-muted small mb-0">Belum ada riwayat penonaktifan.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Merchant</th>
                                <th>Aksi</th>
                                <th>Dilakukan oleh</th>
                                <th>Catatan</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suspensionLogs as $log)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold" style="font-size:14px;">{{ $log->merchant->name ?? 'Akun dihapus' }}</div>
                                        <small class="text-muted">{{ $log->merchant->email ?? '-' }}</small>
                                    </td>
                                    <td>
                                        @if($log->action === 'suspended')
                                            <span class="badge bg-warning text-dark px-3 py-2" style="border-radius:20px;">⛔ Dinonaktifkan</span>
                                        @else
                                            <span class="badge bg-info text-white px-3 py-2" style="border-radius:20px;">🔄 Diaktifkan Kembali</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="small">{{ $log->admin->name ?? 'Admin' }}</span>
                                    </td>
                                    <td class="text-muted small">{{ $log->note ?? '-' }}</td>
                                    <td>
                                        <div style="font-size:13px;">{{ $log->created_at->format('d M Y, H:i') }} WIB</div>
                                        <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection
