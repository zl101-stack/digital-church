@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow-lg p-4 rounded-4">

        <h3 class="fw-bold mb-4">Detail User</h3>

        <div class="mb-3">
            <strong>Nama:</strong>
            <p>{{ $user->name }}</p>
        </div>

        <div class="mb-3">
            <strong>Email:</strong>
            <p>{{ $user->email }}</p>
        </div>

        <div class="mb-3">
            <strong>Role:</strong>
            <p>
                @if($user->role == 'admin')
                <span class="badge bg-success">Admin</span>
                @elseif($user->role == 'user')
                <span class="badge bg-primary">User</span>
                @else
                <span class="badge bg-dark">Superadmin</span>
                @endif
            </p>
        </div>

        <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>

    </div>

</div>

@endsection