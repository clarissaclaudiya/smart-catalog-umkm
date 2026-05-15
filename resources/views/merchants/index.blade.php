@extends('layouts.app')

@section('content')
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold" style="color: #6c5ce7;">Merchant Aktif</h5>
                <small class="text-muted">Daftar merchant yang sudah disetujui dan aktif kerjasama</small>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <a href="/merchants/history" class="btn btn-sm btn-light px-3" style="border-radius: 8px;">
                    📜 History
                </a>
                <a href="/merchants/suspended" class="btn btn-sm btn-outline-secondary px-3" style="border-radius: 8px;">
                    ⛔ Nonaktif
                    @php $suspCount = \App\Models\User::where('role','merchant')->where('status','suspended')->count(); @endphp
                    @if($suspCount > 0)
                        <span class="badge bg-secondary ms-1">{{ $suspCount }}</span>
                    @endif
                </a>
                <a href="/merchants/pending" class="btn btn-sm btn-warning text-white px-3" style="border-radius: 8px;">
                    ⏳ Menunggu Persetujuan
                    @php
                        $pendingCount = \App\Models\User::where('role', 'merchant')->where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="badge bg-danger ms-1">{{ $pendingCount }}</span>
                    @endif
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning border-0 shadow-sm">{{ session('warning') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Merchant</th>
                            <th>Email</th>
                            <th>Bergabung</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($merchants as $key => $merchant)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:38px; height:38px; border-radius:50%; background: linear-gradient(135deg, #6c5ce7, #a29bfe); display:flex; align-items:center; justify-content:center; color:white; font-weight:600; font-size:15px; flex-shrink:0;">
                                            {{ strtoupper(substr($merchant->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-bold">{{ $merchant->name }}</span>
                                    </div>
                                </td>
                                <td class="text-muted">{{ $merchant->email }}</td>
                                <td class="text-muted small">{{ $merchant->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-success px-3 py-2" style="border-radius: 20px; font-size: 12px;">
                                        ✅ Aktif
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form action="/merchants/suspend/{{ $merchant->id }}" method="POST"
                                            onsubmit="return confirm('Nonaktifkan merchant {{ $merchant->name }}?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning px-3"
                                                style="border-radius: 8px; font-size: 12px;">
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div style="font-size: 40px; margin-bottom: 10px;">🏪</div>
                                    <p class="mb-0">Belum ada merchant aktif.</p>
                                    <small>Merchant yang disetujui akan muncul di sini.</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary Card -->
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card border-0 text-center p-3" style="background: #f8f9ff; border-radius: 12px;">
                        <div class="fw-bold" style="font-size: 24px; color: #6c5ce7;">{{ $merchants->count() }}</div>
                        <small class="text-muted">Merchant Aktif</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 text-center p-3" style="background: #fff8f0; border-radius: 12px;">
                        <div class="fw-bold text-warning" style="font-size: 24px;">{{ $pendingCount }}</div>
                        <small class="text-muted">Menunggu Persetujuan</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="/merchants/suspended" style="text-decoration: none;">
                        <div class="card border-0 text-center p-3" style="background: #fff0f0; border-radius: 12px;">
                            @php
                                $nonaktifCount = \App\Models\User::where('role','merchant')
                                    ->where('status', 'suspended')->count();
                            @endphp
                            <div class="fw-bold text-danger" style="font-size: 24px;">{{ $nonaktifCount }}</div>
                            <small class="text-muted">Merchant Nonaktif</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
