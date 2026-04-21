@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Edit Donasi</h2>

    <form action="/donations/{{ $donation->id }}" method="POST">
        @csrf
        @method('PUT')

        <input type="number" name="amount" value="{{ $donation->amount }}" class="form-control mb-2">
        <input type="date" name="date" value="{{ $donation->date }}" class="form-control mb-2">
        <textarea name="note" class="form-control mb-2">{{ $donation->note }}</textarea>

        <button class="btn btn-primary">Update</button>
    </form>
</div>

@endsection