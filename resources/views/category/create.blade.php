@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold" style="color: #6c5ce7;">Tambah Kategori Baru</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Pastikan ada enctype="multipart/form-data" untuk upload foto -->
                    <form action="/categories/store" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Input Nama -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Makanan Ringan"
                                required>
                        </div>

                        <!-- Input Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Deskripsi Kategori</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Jelaskan kategori ini secara singkat..."></textarea>
                        </div>

                        <!-- Input Foto/Icon -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Icon/Foto Kategori</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB.</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg shadow-sm"
                                style="background-color: #a29bfe; color: white; border-radius: 12px; font-weight: 600;">
                                Simpan Kategori
                            </button>
                            <a href="/categories" class="btn btn-link text-muted">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection