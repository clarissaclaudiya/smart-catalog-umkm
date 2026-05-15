@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="card border-0 shadow-sm mb-4"
        style="border-radius: 15px; background: linear-gradient(135deg, #636e72, #b2bec3); color: white;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">📜 History Persetujuan Merchant Baru</h4>
                <p class="mb-0 opacity-85">Rekam jejak keputusan admin terhadap pendaftaran akun merchant baru (Disetujui / Ditolak)</p>
            </div>
            <div style="font-size: 48px;">🗂️</div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold" style="color: #636e72;">Log Aktivitas</h5>
                <small class="text-muted">{{ $logs->total() }} total aktivitas tercatat</small>
            </div>
            <a href="/merchants" class="btn btn-sm btn-light" style="border-radius: 8px;">← Kembali</a>
        </div>
        <div class="card-body p-0">
            @if($logs->isEmpty())
                <div class="text-center py-5">
                    <div style="font-size: 64px; margin-bottom: 16px;">📭</div>
                    <h5 class="fw-bold text-muted">Belum ada history</h5>
                    <p class="text-muted">Tindakan approve/reject/suspend akan tercatat di sini.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Merchant</th>
                                <th>Tindakan</th>
                                <th>Diproses oleh</th>
                                <th>Catatan</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $key => $log)
                                <tr>
                                    <td class="ps-4 text-muted">{{ $logs->firstItem() + $key }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:34px; height:34px; border-radius:50%; background: linear-gradient(135deg, #6c5ce7, #a29bfe); display:flex; align-items:center; justify-content:center; color:white; font-weight:600; font-size:13px; flex-shrink:0;">
                                                {{ strtoupper(substr($log->merchant->name ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold" style="font-size: 14px;">{{ $log->merchant->name ?? 'Akun dihapus' }}</div>
                                                <small class="text-muted">{{ $log->merchant->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{!! $log->action_badge !!}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:28px; height:28px; border-radius:50%; background:#e17055; display:flex; align-items:center; justify-content:center; color:white; font-weight:600; font-size:11px; flex-shrink:0;">
                                                {{ strtoupper(substr($log->admin->name ?? 'A', 0, 1)) }}
                                            </div>
                                            <span class="small">{{ $log->admin->name ?? 'Admin' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted small" style="max-width: 200px;">
                                        {{ $log->note ?? '-' }}
                                    </td>
                                    <td>
                                        <div style="font-size: 13px;">{{ $log->created_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $log->created_at->format('H:i') }} WIB</small>
                                        <div class="text-muted" style="font-size: 11px;">{{ $log->created_at->diffForHumans() }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($logs->hasPages())
                    <div class="p-4 border-top d-flex justify-content-center">
                        {{ $logs->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
