<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart-Catalog UMKM</title>
    <!-- Kamu bisa tambah CSS Bootstrap di sini nanti agar tampilan rapi -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding: 20px;
        }

        .content {
            flex: 1;
            padding: 20px;
            background: #f8f9fa;
        }

        .navbar-custom {
            background: white;
            border-bottom: 1px solid #ddd;
            padding: 10px 20px;
        }
    </style>
</head>

<body>

    <!-- 1. SIDEBAR (Komponen yang tetap ada) -->
    <div class="sidebar">
        <h3>Smart-UMKM</h3>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="/dashboard" class="nav-link text-white">Dashboard</a></li>
            <li class="nav-item"><a href="/categories" class="nav-link text-white">Kelola Kategori</a></li>
            <li class="nav-item"><a href="/products" class="nav-link text-white">Kelola Produk</a></li>
        </ul>
    </div>

    <div class="content">
        <!-- 2. NAVBAR (Menampilkan Nama User dari Session) -->
        <nav class="navbar-custom d-flex justify-content-between">
            <span>Platform Katalog Resmi</span>
            @auth
                <strong>Halo, {{ Auth::user()->name }}!</strong>
            @endauth
        </nav>

        <!-- 3. TEMPAT KONTEN DINAMIS -->
        <div class="container-fluid mt-4">
            @yield('content')
            <!-- Di sinilah isi dari halaman Kategori/Produk akan muncul -->
        </div>
    </div>

</body>

</html>