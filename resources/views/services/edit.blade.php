@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Edit Jadwal Pelayanan</h2>

    <form action="/services/{{ $service->id }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="title" value="{{ $service->title }}" class="form-control mb-2">
        <input type="date" name="date" value="{{ $service->date }}" class="form-control mb-2">
        <input type="time" name="time" value="{{ $service->time }}" class="form-control mb-2">
        <input type="text" name="location" value="{{ $service->location }}" class="form-control mb-2">
        <textarea name="description" class="form-control mb-2">{{ $service->description }}</textarea>
        

        <button class="btn btn-primary">Update</button>
    </form>
</div>

@endsection