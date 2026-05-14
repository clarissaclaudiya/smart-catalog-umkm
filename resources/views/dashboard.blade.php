@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm p-4">
                <h3>Selamat Datang di Dashboard!</h3>
                <p>Halo, <strong>{{ Auth::user()->name }}</strong>. Kamu berhasil login ke sistem Smart-Catalog UMKM.</p>
                <hr>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white p-3 mb-3">
                            <h5>Total Kategori</h5>
                            <p class="h2">0</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white p-3 mb-3">
                            <h5>Total Produk</h5>
                            <p class="h2">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
