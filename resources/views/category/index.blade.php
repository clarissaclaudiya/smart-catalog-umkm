@extends('layouts.app')

@section('content')
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold" style="color: #6c5ce7;">Daftar Kategori Produk</h5>
            <a href="/categories/create" class="btn btn-sm"
                style="background-color: #a29bfe; color: white; border-radius: 8px;">+ Tambah Kategori</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Icon</th>
                            <th>Info Kategori</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($item->image)
                                        <img src="{{ asset('storage/categories/' . $item->image) }}" width="50" height="50"
                                            style="object-fit: cover; border-radius: 10px;" class="shadow-sm">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px; border-radius: 10px;">
                                            <span class="text-muted" style="font-size: 10px;">No Pic</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->name }}</div>
                                    <div class="text-muted small">
                                        {{ \Illuminate\Support\Str::limit($item->description, 60) ?? 'Tidak ada deskripsi.' }}
                                    </div>
                                </td>
                                <td>
                                    <a href="/categories/edit/{{ $item->id }}" class="btn btn-sm btn-outline-warning"
                                        style="border-radius: 7px;">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection