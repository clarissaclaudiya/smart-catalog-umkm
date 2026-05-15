@extends('layouts.app')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold" style="color: #6c5ce7;">Persetujuan Order Merchant</h5>
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
                        <th>Merchant</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="fw-bold">{{ $item->user->name }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }} Pcs</td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            <form action="/orders/approve/{{ $item->id }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success px-3" style="border-radius: 8px;">Approve</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Tidak ada antrian order.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
