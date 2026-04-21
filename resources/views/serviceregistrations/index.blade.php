@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">👥 Data Pelayan</h2>

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">

            <form action="/service-registrations" method="POST">
                @csrf

                <input type="text" name="name" class="form-control mb-2" placeholder="Nama Jemaat" required>

                <select name="service_id" class="form-control mb-2" required>
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->title }}</option>
                    @endforeach
                </select>

                <select name="position" class="form-control mb-2" required>
                    <option value="">-- Pilih Posisi --</option>
                    <option value="Vokalis">Vokalis</option>
                    <option value="Gitar">Gitar</option>
                    <option value="Drummer">Drummer</option>
                    <option value="Sound System">Sound System</option>
                </select>

                <button class="btn btn-primary">Tambah</button>
            </form>

        </div>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Jadwal</th>
                <th>Aksi</th>
                <th>Posisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $reg)
            <tr>
                <td>{{ $reg->name }}</td>
                <td>{{ $reg->service->title }}</td>
                <td>{{ $reg->position }}</td>
                <td>

                    <a href="/service-registrations/{{ $reg->id }}/edit" class="btn btn-warning btn-sm">Edit</a>

                    <form action="/service-registrations/{{ $reg->id }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                            Hapus
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection