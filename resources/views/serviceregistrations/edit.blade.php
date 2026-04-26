@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Edit Pelayan</h2>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ✅ TAMBAHAN: ERROR DARI CONTROLLER --}}
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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

        {{-- ✅ FIX: selected posisi --}}
        <select name="position" class="form-control mb-2" required>
            <option value="">-- Pilih Posisi --</option>
            <option value="Vokalis" {{ $registration->position == 'Vokalis' ? 'selected' : '' }}>Vokalis</option>
            <option value="Gitar" {{ $registration->position == 'Gitar' ? 'selected' : '' }}>Gitar</option>
            <option value="Drummer" {{ $registration->position == 'Drummer' ? 'selected' : '' }}>Drummer</option>
            <option value="Sound System" {{ $registration->position == 'Sound System' ? 'selected' : '' }}>Sound System</option>
        </select>

        <button class="btn btn-primary">Update</button>
    </form>
</div>

@endsection