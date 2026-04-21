@extends('layouts.app')

@section('content')

<div class="container"> 
    
<h2 class="mb-4">Jadwal Pelayanan</h2>

<!-- Form tambah -->
<div class="card mb-4">
    <div class="card-body">
        <form action="/services" method="POST">
            @csrf

            <input type="text" 
                   name="title" 
                   class="form-control mb-2" 
                   placeholder="Judul" 
                   required>

            <input type="date" 
                   name="date" 
                   class="form-control mb-2" 
                   required>

            <input type="time" 
                   name="time" 
                   class="form-control mb-2" 
                   required>

            <input type="text" 
                   name="location" 
                   class="form-control mb-2" 
                   placeholder="Lokasi" 
                   required>

            <textarea name="description" 
                      class="form-control mb-2" 
                      placeholder="Deskripsi"></textarea>

            <button class="btn btn-primary">Tambah</button>
        </form>
    </div>
</div>

<!-- Table -->
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Judul</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Lokasi</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($services as $service)
        <tr>
            <td>{{ $service->title }}</td>
            <td>{{ $service->date }}</td>
            <td>{{ $service->time }}</td>
            <td>{{ $service->location }}</td>
            <td>{{ $service->description }}</td>
            <td>
                <a href="/services/{{ $service->id }}/edit" 
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="/services/{{ $service->id }}" 
                      method="POST" 
                      style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm" 
                            onclick="return confirm('Yakin hapus?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection