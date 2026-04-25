@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow-lg p-4 rounded-4">

        <h3 class="fw-bold mb-4">✏️ Edit User</h3>

        <!-- FIX -->
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <!-- NAME -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name"
                           class="form-control rounded-3"
                           value="{{ $user->name }}" required>
                </div>

                <!-- EMAIL -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                           class="form-control rounded-3"
                           value="{{ $user->email }}" required>
                </div>

                <!-- ROLE -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select rounded-3" required>

                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                            User
                        </option>

                    </select>
                </div>

            </div>

            <!-- BUTTON -->
            <div class="d-flex justify-content-between mt-4">
                <!-- FIX -->
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary rounded-pill px-4">
                    ← Kembali
                </a>

                <button class="btn btn-warning text-white rounded-pill px-4">
                    Update
                </button>
            </div>

        </form>

    </div>

</div>

@endsection