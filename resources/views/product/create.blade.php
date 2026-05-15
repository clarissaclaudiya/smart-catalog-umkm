@extends('layouts.app')

@section('content')
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold" style="color: #6c5ce7;">Tambah Produk Baru</h5>
            <a href="/products" class="btn btn-sm btn-light" style="border-radius: 8px;">← Kembali</a>
        </div>
        <div class="card-body p-4">

            {{-- Tampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <strong>Oops! Ada kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/products/store" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kategori Produk</label>
                        <select name="category_id" class="form-select" required style="border-radius: 10px;">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required style="border-radius: 10px;">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" required min="0" style="border-radius: 10px;">
                        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Stok Master</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required min="0" style="border-radius: 10px;">
                        @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Foto Produk <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg" required style="border-radius: 10px;">
                    <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB.</small>
                    @error('image') <br><small class="text-danger">{{ $message }}</small> @enderror

                    {{-- Preview foto sebelum upload --}}
                    <div id="imagePreviewWrapper" class="mt-3" style="display:none;">
                        <p class="text-muted small mb-1">Preview:</p>
                        <img id="imagePreview" src="#" alt="Preview"
                            style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px; border: 2px solid #a29bfe;">
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="/products" class="btn btn-light px-4" style="border-radius: 10px;">Batal</a>
                    <button type="submit" class="btn btn-primary px-4"
                        style="background-color: #6c5ce7; border: none; border-radius: 10px; font-weight: 600;">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview gambar sebelum upload
        document.querySelector('input[name="image"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    document.getElementById('imagePreview').src = ev.target.result;
                    document.getElementById('imagePreviewWrapper').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection