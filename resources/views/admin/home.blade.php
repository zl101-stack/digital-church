@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->
<div class="container-fluid p-0">
    <div class="text-white d-flex align-items-center justify-content-center"
        style="
            height: 100vh;
            background: url('/images/gerejaa.jpeg') center center / cover no-repeat;
            background-attachment: fixed;
            animation: fadeIn 2s ease-out;
        ">

        <div class="text-center"
            style="
                background: rgba(0,0,0,0.7);
                backdrop-filter: blur(15px);
                padding: 60px 40px;
                border-radius: 25px;
                max-width: 800px;
                animation: slideIn 1s ease-out;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            ">

            <h1 class="display-4 fw-bold animated fadeIn" style="font-family: 'Lora', serif;">Tempat Iman, Harapan, dan Kasih</h1>

            <p class="lead mt-3" style="font-family: 'Raleway', sans-serif;">
                Kami adalah komunitas gereja yang bertumbuh bersama dalam kasih Tuhan.
                Bergabunglah dalam pelayanan dan jadilah bagian dari keluarga kami.
            </p>

            <div class="mt-4">
                <a href="/service-registrations" class="btn btn-light btn-lg shadow-lg btn-hover">Daftar Pelayanan</a>
                <a href="/donations" class="btn btn-outline-light btn-lg shadow-lg btn-hover">Donasi Sekarang</a>
            </div>

        </div>
    </div>
</div>

<!-- FITUR -->
<div class="container-fluid px-5 mt-5">
    <div class="row text-center g-4">

        <div class="col-md-3">
            <div class="card shadow-lg bg-dark text-white border-0 transition-transform hover:scale-105 rounded-card">
                <div class="card-body">
                    <h5>📅 Jadwal Pelayanan</h5>
                    <p>Lihat jadwal ibadah dan pelayanan gereja.</p>
                    <a href="/services" class="btn btn-outline-light btn-sm">Lihat</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-lg bg-dark text-white border-0 transition-transform hover:scale-105 rounded-card">
                <div class="card-body">
                    <h5>🙌 Data Pelayanan</h5>
                    <p>Kelola data pelayan dalam setiap ibadah.</p>
                    <a href="/service-registrations" class="btn btn-outline-light btn-sm">Lihat</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-lg bg-dark text-white border-0 transition-transform hover:scale-105 rounded-card">
                <div class="card-body">
                    <h5>💖 Donasi</h5>
                    <p>Kelola data donasi.</p>
                    <a href="/donations" class="btn btn-outline-light btn-sm">Lihat</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-lg bg-dark text-white border-0 transition-transform hover:scale-105 rounded-card">
                <div class="card-body">
                    <h5>🧠 Konseling</h5>
                    <p>Kelola data konseling.</p>
                    <a href="/counseling" class="btn btn-outline-light btn-sm">Lihat</a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

<style>
    /* Google Fonts Import */
    @import url('https://fonts.googleapis.com/css2?family=Lora:wght@400;500;700&family=Raleway:wght@300;400;600&display=swap');

    /* Global font styling */
    body {
        font-family: 'Raleway', sans-serif;
        background-color: #f4f4f9;
    }

    /* Animasi fade-in */
    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    /* Animasi slide-in */
    @keyframes slideIn {
        0% { transform: translateY(30px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    /* Tombol dengan efek hover */
    .btn-lg {
        font-family: 'Lora', serif;
        font-size: 18px;
        padding: 14px 40px;
        letter-spacing: 2px;
        transition: all 0.4s ease;
        text-transform: uppercase;
        border-radius: 30px;
    }

    .btn-lg:hover {
        background: linear-gradient(to right, #ff6a00, #ee0979);
        color: #fff;
        transform: scale(1.1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        transition: all 0.4s ease;
    }

    /* Hover effect untuk tombol */
    .btn-outline-light {
        border-color: #fff;
        color: #fff;
        transition: all 0.4s ease;
        font-family: 'Raleway', sans-serif;
    }

    .btn-outline-light:hover {
        background: #fff;
        color: #333;
        border-color: #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    /* Card hover effect */
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Rounded corners untuk card */
    .rounded-card {
        border-radius: 20px;
    }

    /* Parallax effect */
    .parallax {
        background-image: url('/images/gerejaa.jpeg');
        background-attachment: fixed;
        background-size: cover;
        height: 100vh;
    }

</style>