@extends('layouts.app')

@section('content')
    <div class="text-center mt-5">
        <h3 class="fw-bold mb-3">Selamat Datang di Smart-Catalog!</h3>
        <p class="text-muted mb-4">Silakan daftar untuk mulai memamerkan produk UMKM kamu.</p>
        <button type="button" class="btn btn-lg px-5 shadow-sm" data-bs-toggle="modal" data-bs-target="#registerModal"
            style="background-color: #6c5ce7; color: white; border-radius: 12px; font-weight: 600;">
            Buka Form Pendaftaran
        </button>
    </div>

    <!-- Modal Pop-up Register -->
    <div class="modal fade show" id="registerModal" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">

                <div class="modal-header border-0 py-4" style="background-color: #e8f5e9; border-radius: 25px 25px 0 0;">
                    <div class="w-100 text-center">
                        <h4 class="modal-title fw-bold" style="color: #2e7d32;">Daftar Akun Merchant</h4>
                        <p class="text-muted small mb-0">Platform Katalog UMKM Modern</p>
                    </div>
                    <a href="/" class="btn-close" style="position: absolute; right: 25px; top: 30px;"></a>
                </div>

                <div class="modal-body p-4 bg-white" style="border-radius: 0 0 25px 25px;">
                    <form action="/register" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap / UMKM</label>
                            <input type="text" name="name" class="form-control" style="border-radius: 10px;"
                                placeholder="Contoh: Keripik Berkah" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Bisnis</label>
                            <input type="email" name="email" class="form-control" style="border-radius: 10px;"
                                placeholder="nama@email.com" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" style="border-radius: 10px;"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                style="border-radius: 10px;" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Daftar Sebagai:</label>
                            <select name="role" class="form-select" style="border-radius: 10px;" required>
                                <option value="merchant">Merchant (UMKM)</option>
                                <option value="admin">Admin (Pusat)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 shadow-sm"
                            style="background-color: #a29bfe; color: white; border-radius: 12px; font-weight: 600;">
                            Daftar Sekarang
                        </button>

                        <div class="mt-4 text-center">
                            <small class="text-muted">Sudah punya akun? <a href="/login"
                                    style="color: #6c5ce7; font-weight: 600; text-decoration: none;">Masuk di
                                    sini</a></small>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="/" class="text-muted small" style="text-decoration: none;">← Kembali ke Katalog
                                Utama</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection