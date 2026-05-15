@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="color: #6c5ce7;">Edit Produk</h5>
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

                <form action="/products/update/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Nama Produk</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required style="border-radius: 10px;">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="category_id" class="form-select" required style="border-radius: 10px;">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required style="border-radius: 10px;">
                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Stok Master</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required min="0" style="border-radius: 10px;">
                            @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Foto Produk (Kosongkan jika tidak diubah)</label>

                        {{-- Tampilkan foto saat ini --}}
                        <div class="mb-2">
                            <p class="text-muted small mb-1">Foto saat ini:</p>
                            @if($product->image && $product->image !== 'placeholder.png')
                                <img id="currentImage"
                                    src="{{ asset('storage/products/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 2px solid #a29bfe;">
                            @else
                                <div style="width:100px; height:100px; border-radius:12px; background:#f1f0ff; display:flex; align-items:center; justify-content:center; border: 2px dashed #a29bfe;">
                                    <span class="text-muted small">Belum ada foto</span>
                                </div>
                            @endif
                        </div>

                        <input type="file" name="image" id="imageInput" class="form-control" accept="image/jpeg,image/png,image/jpg" style="border-radius: 10px;">
                        <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                        @error('image') <br><small class="text-danger">{{ $message }}</small> @enderror

                        {{-- Preview foto baru --}}
                        <div id="newPreviewWrapper" class="mt-2" style="display:none;">
                            <p class="text-muted small mb-1">Preview foto baru:</p>
                            <img id="newImagePreview" src="#" alt="Preview Baru"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 2px solid #00b894;">
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="/products" class="btn btn-light px-4" style="border-radius: 10px;">Batal</a>
                        <button type="submit" class="btn btn-primary px-4"
                            style="background-color: #6c5ce7; border: none; border-radius: 10px; font-weight: 600;">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview gambar baru sebelum upload
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('newImagePreview').src = ev.target.result;
                document.getElementById('newPreviewWrapper').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('newPreviewWrapper').style.display = 'none';
        }
    });
</script>
@endsection
