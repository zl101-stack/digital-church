@extends('layouts.app')

@section('content')

<style>
    /* Global styling for dark theme */
    body {
        background-color: #121212; /* Dark background */
        color: #e0e0e0; /* Light text for contrast */
        font-family: 'Roboto', sans-serif;
    }

    h2 {
        font-size: 36px;
        font-weight: 700;
        color: #ffffff; /* White color for headings */
    }

    .card-hover {
        transition: 0.3s ease-in-out;
        border-radius: 15px;
    }

    .card-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0px 20px 30px rgba(0, 0, 0, 0.4); /* Darker shadow for depth */
    }

    .card-body {
        border-radius: 15px;
    }

    .card-title {
        font-size: 24px;
        font-weight: 600;
        color: #ffffff; /* White text for card titles */
    }

    .card .btn {
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        border-radius: 30px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
    }

    /* Card Color Schemes */
    .card.bg-primary {
        background-color: #1d3557; /* Dark blue */
    }

    .card.bg-success {
        background-color: #2d6a4f; /* Dark green */
    }

    .card.bg-info {
        background-color: #457b9d; /* Dark cyan */
    }

    .card.bg-warning {
        background-color: #e9c46a; /* Dark yellow */
    }

    /* Card Buttons */
    .btn-light {
        background-color: #444444;
        color: #ffffff;
        border: none;
    }

    .btn-light:hover {
        background-color: #555555;
        color: #ff6a00;
    }

    .btn-dark {
        background-color: #343a40;
        color: #fff;
    }

    .btn-dark:hover {
        background-color: #212529;
    }

    /* Card Content */
    .card-body h2,
    .card-body p {
        font-size: 28px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    /* Styling for Container */
    .container {
        padding-top: 40px;
        padding-bottom: 40px;
    }

    /* Animations */
    .fadeIn {
        animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Navbar Custom Styling for Dark Theme */
    .navbar {
        background-color: #1f1f1f;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .navbar-nav .nav-link {
        color: #ffffff !important;
        font-size: 16px;
        padding: 10px 15px;
        text-transform: uppercase;
    }

    .navbar-nav .nav-link:hover {
        color: #ff6a00 !important;
        background-color: transparent;
        border-radius: 5px;
    }

    .navbar-toggler-icon {
        background-color: #ffffff;
    }
</style>

<div class="container mt-4 fadeIn">

    <h2 class="mb-4">Dashboard</h2>

    <div class="row">

        <!-- Total Jadwal -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary card-hover">
                <div class="card-body">
                    <h5 class="card-title">📅 Total Jadwal</h5>
                    <h2>{{ $totalServices ?? 0 }}</h2>
                    <a href="/services" class="btn btn-light mt-2">Lihat Jadwal</a>
                </div>
            </div>
        </div>

        <!-- Total Donasi -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success card-hover">
                <div class="card-body">
                    <h5 class="card-title">💰 Total Donasi</h5>
                    <h2>Rp {{ number_format($totalDonations ?? 0) }}</h2>
                    <a href="/donations" class="btn btn-light mt-2">Lihat Donasi</a>
                </div>
            </div>
        </div>

        <!-- Konseling -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-info card-hover">
                <div class="card-body">
                    <h5 class="card-title">🧠 Konseling Jemaat</h5>
                    <p>Kelola jadwal konseling</p>
                    <a href="/counseling" class="btn btn-light mt-2">Lihat Konseling</a>
                </div>
            </div>
        </div>

        <!-- Welcome -->
        <div class="col-md-4 mb-4">
            <div class="card text-dark bg-warning card-hover">
                <div class="card-body">
                    <h5 class="card-title">👋 Selamat Datang</h5>

                    @auth
                        <p>{{ auth()->user()->name }}</p>
                    @else
                        <p>Guest</p>
                    @endauth

                    <a href="/" class="btn btn-dark mt-2">Home</a>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection