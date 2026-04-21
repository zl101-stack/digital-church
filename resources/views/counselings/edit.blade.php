    @extends('layouts.app')

    @section('content')

    <div class="container">
        <h2>Edit Konseling</h2>

        @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="/counseling/{{ $counseling->id }}" method="POST">
            @csrf
            @method('PUT')
            <select name="pastor_id" class="form-control mb-2" required>
                <option value="">-- Pilih Pastor --</option>

                @foreach($pastors as $pastor)
                <option value="{{ $pastor->id }}"
                    {{ $counseling->pastor_id == $pastor->id ? 'selected' : '' }}>
                    {{ $pastor->name }}
                </option>
                @endforeach

            </select>

            <input type="date" name="date" value="{{ $counseling->date }}" class="form-control mb-2" required>

            <input type="time" name="time" value="{{ $counseling->time }}" class="form-control mb-2" required>

            <select name="duration" class="form-control mb-2">
                <option value="30" {{ $counseling->duration == 30 ? 'selected' : '' }}>
                    30 Menit
                </option>
                <option value="60" {{ $counseling->duration == 60 ? 'selected' : '' }}>
                    1 Jam
                </option>
            </select>

            <textarea name="note" class="form-control mb-2">{{ $counseling->note }}</textarea>

            <div class="form-check mb-2">
                <input type="checkbox" name="is_anonymous" class="form-check-input"
                    {{ $counseling->is_anonymous ? 'checked' : '' }}>
                <label class="form-check-label">Anonim</label>
            </div>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>

    @endsection