@extends('layouts.user')

@section('content')

<style>
    .welcome-box {
        background: linear-gradient(135deg, #4c6ef5, #15aabf);
        color: white;
        padding: 25px;
        border-radius: 20px;
        margin-bottom: 25px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .card-genz {
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        background: white;
        transition: 0.3s;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .card-genz:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .icon-box {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .btn-modern {
        border-radius: 12px;
        padding: 8px 20px;
        font-weight: 500;
    }
</style>


<div class="welcome-box">
    <h3>Welcome back, {{ auth()->user()->name }} 👋</h3>
    <p class="mb-0">Stay connected with your church activities</p>
</div>

<div class="row">

    <div class="col-md-3 mb-4">
        <div class="card-genz">
            <div class="icon-box">📅</div>
            <h5>Jadwal</h5>
            <a href="/services" class="btn btn-primary btn-modern mt-2">Explore</a>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card-genz">
            <div class="icon-box">💰</div>
            <h5>Donasi</h5>
            <a href="/donations" class="btn btn-success btn-modern mt-2">Support</a>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card-genz">
            <div class="icon-box">🙌</div>
            <h5>Pelayanan</h5>
            <a href="/service-registrations" class="btn btn-warning btn-modern mt-2">Join</a>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card-genz">
            <div class="icon-box">🧠</div>
            <h5>Konseling</h5>
            <a href="/counseling" class="btn btn-info btn-modern mt-2">Talk</a>
        </div>
    </div>

</div>

@endsection