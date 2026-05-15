@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm mt-5" style="border-radius: 20px;">
                <div class="card-header border-0 text-center py-4" style="background-color: #f1f0ff;">
                    <h4 class="mb-0" style="color: #6c5ce7; font-weight: 600;">Login Portal</h4>
                    <p class="text-muted small mb-0">Masuk sesuai dengan hak akses akun kamu</p>
                </div>
                <div class="card-body p-4 bg-white" style="border-radius: 0 0 20px 20px;">
                    @if(session('error'))
                        <div class="alert alert-danger border-0 small">{{ session('error') }}</div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success border-0 small">{{ session('success') }}</div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Masuk Sebagai:</label>
                            <select name="role" class="form-select" style="border-radius: 12px; font-size: 14px;" required>
                                <option value="merchant">Merchant (UMKM)</option>
                                <option value="admin">Admin (Pusat)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Bisnis</label>
                            <input type="email" name="email" class="form-control form-control-lg"
                                style="font-size: 14px; border-radius: 12px;" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg"
                                style="font-size: 14px; border-radius: 12px;" required>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 shadow-sm mb-3"
                            style="background-color: #6c5ce7; color: white; border-radius: 12px; font-weight: 600;">
                            Masuk Sekarang
                        </button>

                        <div class="text-center">
                            <small class="text-muted">Belum punya akun? <a href="/register"
                                    style="color: #6c5ce7; font-weight: 600; text-decoration: none;">Daftar di
                                    sini</a></small>
                        </div>

                        <hr class="my-4">

                        <div class="text-center">
                            <a href="/" class="text-muted small" style="text-decoration: none;">← Kembali ke Katalog
                                Utama</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection