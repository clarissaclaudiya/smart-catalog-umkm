@extends('layouts.app') <!-- Menyambung ke file app.blade.php yang sedang kamu buka di gambar -->

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Kategori Baru</h5>
                </div>
                <div class="card-body">

                    <!-- PENTING: enctype="multipart/form-data" wajib ada untuk upload foto -->
                    <form action="/categories/store" method="POST" enctype="multipart/form-data">
                        @csrf <!-- Token keamanan Laravel -->

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Contoh: Makanan Ringan" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Foto Bukti Fisik (Wajib)</label>
                            <!-- Input file untuk foto produk -->
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB.</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/categories" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success">Simpan Kategori</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection