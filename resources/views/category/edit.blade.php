@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold" style="color: #e67e22;">Ubah Kategori</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/categories/update/{{ $category->id }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Nama Kategori</label>
                            <input type="text" name="name" value="{{ $category->name }}"
                                class="form-control form-control-lg" style="border-radius: 10px; font-size: 15px;" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg btn-warning shadow-sm"
                                style="color: white; border-radius: 12px; font-weight: 600;">
                                Perbarui Kategori
                            </button>
                            <a href="/categories" class="btn btn-link text-muted" style="text-decoration: none;">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection