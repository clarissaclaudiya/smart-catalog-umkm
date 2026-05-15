@extends('layouts.app')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold" style="color: #6c5ce7;">Master Produk Admin</h5>
            <a href="/products/create" class="btn btn-sm btn-success px-3" style="border-radius: 8px;">+ Tambah Produk</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($item->image && $item->image !== 'placeholder.png' && Storage::disk('public')->exists('products/' . $item->image))
                                        <img src="{{ asset('storage/products/' . $item->image) }}"
                                            alt="{{ $item->name }}"
                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;"
                                            class="shadow-sm">
                                    @else
                                        <div style="width:60px; height:60px; border-radius:10px; background:#f1f0ff; display:flex; align-items:center; justify-content:center;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#a29bfe" viewBox="0 0 16 16">
                                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ $item->name }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $item->category->name ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>
                                <td class="text-success fw-bold">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge {{ $item->stock > 5 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->stock }} Pcs
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="/products/edit/{{ $item->id }}" class="btn btn-sm btn-warning text-white" style="border-radius: 8px;">Edit</a>
                                        <form action="/products/{{ $item->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 8px;">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada produk. Silakan tambah produk baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection