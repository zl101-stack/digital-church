<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Digital Church</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Anti Cache -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }

        .card {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        .navbar {
            background-color: #222 !important;
        }

        .navbar-nav .nav-link:hover {
            color: #ff6a00 !important;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid px-4">

            <a class="navbar-brand" href="/dashboard">
                <i class="fas fa-church"></i> Digital Church Admin
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/services">Jadwal</a>
                    </li>

                    <!-- ✅ INI BAGIAN YANG DIPERBAIKI -->
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin'
                                ? route('service-registrations.index')
                                : route('user.pelayanan') }}">
                            Pelayanan
                        </a>
                    </li>
                    <!-- ✅ END FIX -->

                    <li class="nav-item">
                        <a class="nav-link" href="/donations">Donasi</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/counseling">Konseling</a>
                    </li>

                    <li class="nav-item">
                        <span class="nav-link text-warning">
                            👤 {{ auth()->user()->name ?? 'Admin' }}
                        </span>
                    </li>

                    <li class="nav-item ms-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container-fluid p-0">
        @yield('content')
    </div>

    <!-- FOOTER -->
    <footer class="bg-dark text-white text-center mt-5 p-3">
        <small>© {{ date('Y') }} Digital Church. All rights reserved.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>