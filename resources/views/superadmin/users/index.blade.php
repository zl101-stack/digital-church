@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow-lg p-4 rounded-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold">Kelola User & Admin</h3>

            <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary rounded-pill px-4">
                + Buat Akun Baru
            </a>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <!-- ROLE BADGE -->
                        <td>
                            @if($user->role == 'admin')
                            <span class="badge bg-success px-3 py-2 rounded-pill">admin</span>
                            @elseif($user->role == 'user')
                            <span class="badge bg-primary px-3 py-2 rounded-pill">user</span>
                            @else
                            <span class="badge bg-dark px-3 py-2 rounded-pill">superadmin</span>
                            @endif
                        </td>

                        <!-- ACTION BUTTON -->
                        <td>
                            <!-- DETAIL -->
                            <a href="{{ route('superadmin.users.show', $user->id) }}"
                                class="btn btn-secondary btn-sm rounded-pill">
                                Detail
                            </a>

                            <!-- EDIT -->
                            <a href="{{ route('superadmin.users.edit', $user->id) }}"
                                class="btn btn-warning btn-sm rounded-pill text-white">
                                Edit
                            </a>

                            <!-- DELETE -->
                            <form action="{{ route('superadmin.users.destroy', $user->id) }}"
                                method="POST" class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="btn btn-danger btn-sm rounded-pill"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')">

                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <!-- FOOTER -->
        <div class="d-flex justify-content-between mt-3">
            <a href="{{ auth()->user()->role == 'admin' 
            ? route('admin.dashboard') 
            : route('superadmin.dashboard') }}"
                class="text-decoration-none">

                ← Kembali ke Dashboard
            </a>

            <a href="/auto-logout" class="btn btn-danger rounded-pill px-4">
                Logout
            </a>
        </div>

    </div>

</div>

@endsection