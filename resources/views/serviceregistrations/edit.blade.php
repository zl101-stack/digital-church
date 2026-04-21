@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Edit Pelayan</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="/service-registrations/{{ $registration->id }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $registration->name }}" class="form-control mb-2" required>

        <select name="service_id" class="form-control mb-2" required>
            @foreach($services as $service)
            <option value="{{ $service->id }}"
                {{ $registration->service_id == $service->id ? 'selected' : '' }}>
                {{ $service->title }}
            </option>
            @endforeach
        </select>

        <select name="position" class="form-control mb-2" required>
            <option value="">-- Pilih Posisi --</option>
            <option value="Vokalis">Vokalis</option>
            <option value="Gitar">Gitar</option>
            <option value="Drummer">Drummer</option>
            <option value="Sound System">Sound System</option>
        </select>

        <button class="btn btn-primary">Update</button>
    </form>
</div>

@endsection