@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow-lg p-4 rounded-4">

        <h3 class="fw-bold mb-4">➕ Buat User / Admin</h3>

        <form action="{{ route('superadmin.users.store') }}" method="POST">
            @csrf

            <div class="row">

                <!-- NAME -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control rounded-3"
                        placeholder="Masukkan nama" required>
                </div>

                <!-- EMAIL -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control rounded-3"
                        placeholder="Masukkan email" required>
                </div>

                <!-- PASSWORD -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control rounded-3"
                        placeholder="Masukkan password" required>
                </div>

                <!-- ROLE -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select rounded-3" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

            </div>

            <!-- BUTTON -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary rounded-pill px-4">
                    ← Kembali
                </a>

                <button class="btn btn-primary rounded-pill px-4">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection