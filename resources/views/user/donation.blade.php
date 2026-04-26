@extends('layouts.user')

@section('content')

<style>
    body {
        background: #0f172a;
        color: white;
    }

    .card-box {
        background: #1e293b;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
    }

    .title {
        font-size: 35px;
        font-weight: 700;
        color: #ffffff;
    }

    .subtitle {
        color: #cbd5e1;
    }

    label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #ffffff;
    }

    .form-control {
        background: #334155;
        border: 1px solid #475569;
        color: #ffffff;
        border-radius: 12px;
        padding: 12px;
    }

    .form-control::placeholder {
        color: #cbd5e1;
    }

    .form-control:focus {
        background: #334155;
        color: #ffffff;
        border: 1px solid #22c55e;
        box-shadow: none;
    }

    textarea.form-control {
        resize: none;
    }

    .form-check-input {
        background-color: #334155;
        border: 1px solid #64748b;
    }

    .form-check-input:checked {
        background-color: #22c55e;
        border-color: #22c55e;
    }

    .form-check-label {
        color: #e2e8f0;
    }

    small {
        color: #cbd5e1;
    }

    .btn-success {
        padding: 12px 30px;
        font-weight: 600;
        font-size: 16px;
    }

    .alert-success {
        background: #166534;
        color: #ffffff;
        border: none;
    }

    .btn-outline-light {
        border: 2px solid #cbd5e1;
        color: #cbd5e1;
        transition: 0.3s;
    }

    .btn-outline-light:hover {
        background: #22c55e;
        border-color: #22c55e;
        color: white;
    }
</style>

<div class="container py-5">

    <!-- 🔥 BUTTON (KIRI, TANPA NAVBAR) -->
    <div class="mb-4">
        <a href="{{ route('user.home') }}" class="btn btn-outline-light rounded-pill px-4">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="mb-4 text-center">
        <h1 class="title">💖 Donasi Gereja</h1>
        <p class="subtitle">Berkatilah pelayanan melalui donasi terbaikmu</p>
    </div>

    <div class="card card-box p-4 mx-auto" style="max-width:600px;">

        @if(session('success'))
        <div class="alert alert-success rounded-3">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('user.donation.store') }}">
            @csrf

            <!-- JUMLAH -->
            <div class="mb-4">
                <label for="amount">💰 Jumlah Donasi</label>
                <input
                    type="number"
                    name="amount"
                    id="amount"
                    class="form-control"
                    placeholder="Contoh: 100000"
                    required>
                <small>Masukkan nominal donasi dalam Rupiah</small>
            </div>

            <!-- CATATAN -->
            <div class="mb-4">
                <label for="note">📝 Deskripsi / Catatan</label>
                <textarea
                    name="note"
                    id="note"
                    rows="4"
                    class="form-control"
                    placeholder="Contoh: Persembahan Minggu / Donasi Pembangunan Gereja"></textarea>
                <small>Opsional, isi jika ingin memberi keterangan</small>
            </div>

            <!-- ANONIM -->
            <div class="mb-4 form-check">
                <input type="checkbox" name="is_anonymous" class="form-check-input" id="anonim">
                <label class="form-check-label" for="anonim">
                    🙈 Donasi sebagai anonim
                </label>
            </div>

            <!-- BUTTON -->
            <div class="text-center">
                <button class="btn btn-success rounded-pill px-5">
                    Kirim Donasi
                </button>
            </div>

        </form>

    </div>

</div>

@endsection