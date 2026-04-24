<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Digital Church</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Church System</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">Dashboard</a>
                        </li>

                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                            <li class="nav-item">
                                <a class="nav-link" href="/services">Services</a>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'superadmin')
                            <li class="nav-item">
                                <a class="nav-link" href="/donations">Donations</a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="/auto-logout">Logout</a>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>