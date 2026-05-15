<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart-Catalog UMKM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: sticky;
            top: 0;
            background: #ffffff;
            padding: 25px 20px;
            border-right: 1px solid #e0e0e0;
        }

        .sidebar h3 {
            color: #6c5ce7;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .nav-link {
            color: #555 !important;
            margin-bottom: 12px;
            border-radius: 10px;
            padding: 12px 15px !important;
            transition: 0.3s;
        }

        .nav-link:hover {
            background-color: #f1f0ff;
            color: #6c5ce7 !important;
        }

        .content {
            flex: 1;
            padding: 30px;
        }

        .navbar-custom {
            background: #ffffff;
            border-bottom: 1px solid #eee;
            padding: 15px 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }
    </style>
</head>

<body>
    <!-- SIDEBAR -->
    <div class="sidebar d-flex flex-column">
        <div class="flex-grow-1">
            <h3>Smart-UMKM</h3>
            <ul class="nav flex-column">
                @auth
                    <li class="nav-item"><a href="/dashboard" class="nav-link">Dashboard</a></li>
                    
                    @if(Auth::user()->role == 'admin')
                        <!-- Menu Admin -->
                        <li class="nav-header mt-3 mb-2 small text-muted fw-bold">MENU ADMIN</li>
                        <li class="nav-item"><a href="/categories" class="nav-link">🗂️ Kelola Kategori</a></li>
                        <li class="nav-item"><a href="/products" class="nav-link">📦 Master Produk</a></li>
                        <li class="nav-item"><a href="/orders/admin" class="nav-link">📋 Persetujuan Order</a></li>
                        <li class="nav-item"><a href="/orders/history" class="nav-link">📊 History Order</a></li>

                        <li class="nav-header mt-3 mb-2 small text-muted fw-bold">KELOLA MERCHANT</li>
                        <li class="nav-item"><a href="/merchants" class="nav-link">🏪 Merchant Aktif</a></li>
                        <li class="nav-item">
                            <a href="/merchants/pending" class="nav-link d-flex justify-content-between align-items-center">
                                ⏳ Persetujuan Baru
                                @php $pendingCount = \App\Models\User::where('role','merchant')->where('status','pending')->count(); @endphp
                                @if($pendingCount > 0)
                                    <span class="badge bg-danger rounded-pill" style="font-size: 10px;">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item"><a href="/merchants/history" class="nav-link">📜 History Persetujuan</a></li>
                    @else
                        <!-- Menu Merchant -->
                        <li class="nav-header mt-3 mb-2 small text-muted fw-bold">MENU MERCHANT</li>
                        <li class="nav-item"><a href="/orders/create" class="nav-link">🛒 Belanja Barang</a></li>
                        <li class="nav-item">
                            <a href="/cart" class="nav-link d-flex justify-content-between align-items-center">
                                🧺 Keranjang Saya
                                @php $cartCount = \App\Models\Cart::where('user_id', Auth::id())->count(); @endphp
                                @if($cartCount > 0)
                                    <span class="badge bg-danger rounded-pill" style="font-size: 10px;">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item"><a href="/my-stock" class="nav-link">📦 Stok Toko Saya</a></li>
                        <li class="nav-item"><a href="/my-orders" class="nav-link">🧾 History Order Saya</a></li>
                    @endif
                @else
                    <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="/register" class="nav-link">Register</a></li>
                @endauth
            </ul>
        </div>
        @auth
            <div class="mt-auto border-top pt-4 text-center">
                <small class="text-muted d-block mb-2">Sesi Aktif</small>
            </div>
        @endauth
    </div>

    <!-- MAIN CONTENT -->
    <div class="content">
        <nav class="navbar-custom d-flex justify-content-between align-items-center">
            <span class="text-secondary fw-bold">Platform Katalog Resmi UMKM</span>
            @auth
                <div class="d-flex align-items-center">
                    <span class="me-2 small text-muted text-uppercase">{{ Auth::user()->role == 'admin' ? 'Admin:' : 'Merchant:' }}</span>
                    <strong style="color: #6c5ce7;">{{ Auth::user()->name }}</strong>
                    <span class="badge {{ Auth::user()->role == 'admin' ? 'bg-danger' : 'bg-primary' }} text-uppercase ms-2 me-3" style="font-size: 10px;">
                        {{ Auth::user()->role }}
                    </span>

                    <!-- Tombol Logout Ikon -->
                    <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-2"
                        style="border-radius: 8px; padding: 5px 12px;" data-bs-toggle="modal"
                        data-bs-target="#logoutConfirmModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                            <path fill-rule="evenodd"
                                d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                        </svg>
                        <span class="fw-bold small">Logout</span>
                    </button>
                </div>
            @endauth
        </nav>

        <!-- TEMPAT ISI HALAMAN (JANGAN SAMPAI HAPUS INI) -->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <!-- Modal Konfirmasi Logout (Di luar content) -->
    <div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 350px;">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-body text-center p-4">
                    <div class="mb-3 text-danger text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                        </svg>
                    </div>
                    <h5 class="fw-bold">Yakin ingin keluar?</h5>
                    <p class="text-muted small">Sesi kamu akan berakhir dan kamu harus login kembali.</p>
                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal"
                            style="border-radius: 10px;">Batal</button>
                        <form action="/logout" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100" style="border-radius: 10px;">Ya,
                                Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>