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

    <!-- Style tambahan -->
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
            transition: background-color 0.3s ease-in-out;
        }

        .navbar-toggler-icon {
            background-color: #ffffff;
            border-radius: 3px;
        }

        .navbar-nav .nav-link {
            font-size: 16px;
            padding: 10px 15px;
            transition: color 0.3s ease-in-out;
        }

        .btn {
            margin-top: 8px;
        }

        .navbar-nav .nav-link:hover {
            color: #ff6a00 !important;
            background-color: transparent;
            border-radius: 5px;
        }

        .navbar-brand {
            font-weight: bold;
            color: #ffffff;
            font-size: 24px;
            transition: color 0.3s ease-in-out;
        }

        .navbar-brand:hover {
            color: #ff6a00;
        }

        footer {
            background-color: #000;
            text-align: center;
            padding: 15px;
        }

        footer small {
            font-size: 14px;
        }

        .navbar-nav .nav-item.active .nav-link {
            color: #ff6a00 !important;
            font-weight: 600;
        }


        /* Dropdown */
        .navbar-nav .nav-item.dropdown .dropdown-menu {
            background: #333;
            border-radius: 10px;
        }

        .navbar-nav .nav-item.dropdown .dropdown-item {
            color: #fff;
        }

        .navbar-nav .nav-item.dropdown .dropdown-item:hover {
            background-color: #ff6a00;
            color: #fff;
        }

        /* Navbar in Mobile */
        .navbar-toggler {
            border-color: transparent;
        }

        /* Animasi untuk menu slide-in */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .collapse.show {
            animation: slideIn 0.5s ease-out;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid px-4">

            <!-- Brand with Icon -->
            <a class="navbar-brand" href="/dashboard">
                <i class="fas fa-church"></i> Digital Church Admin
            </a>

            <!-- Hamburger Toggle Button for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/services">Jadwal</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/service-registrations">Pelayanan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/donations">Donasi</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/counseling">Konseling</a>
                    </li>

                    <!-- Admin Name -->
                    <li class="nav-item">
                        <span class="nav-link text-warning">
                            👤 {{ auth()->user()->name ?? 'Admin' }}
                        </span>
                    </li>

                    <!-- Logout Button -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if(auth()->check())
    <script>
        window.addEventListener('beforeunload', function() {
            navigator.sendBeacon('/auto-logout');
        });
    </script>
    @endif

</body>

</html>