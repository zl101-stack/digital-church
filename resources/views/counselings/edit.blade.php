@extends('layouts.app')

@section('content')

<style>
    .edit-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 16px;
        overflow: hidden;
    }
    .edit-card .form-control,
    .edit-card .form-select {
        background: #0f172a;
        border: 1px solid #334155;
        color: #e2e8f0;
        border-radius: 10px;
    }
    .edit-card .form-control:focus,
    .edit-card .form-select:focus {
        background: #0f172a;
        border-color: #6366f1;
        color: #e2e8f0;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
    }
    .edit-card .form-label {
        color: #94a3b8;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .edit-card .form-control::placeholder { color: #475569; }
    .edit-card select option { background: #0f172a; }
</style>

<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="edit-card shadow">

                <div class="px-4 py-3 d-flex align-items-center gap-3"
                    style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                    <div style="font-size:22px;">✏️</div>
                    <div>
                        <div class="fw-bold text-white">Edit Slot Jadwal</div>
                        <div style="font-size:12px;color:rgba(255,255,255,0.7);">
                            {{ $counseling->pastor->name ?? '' }} —
                            {{ \Carbon\Carbon::parse($counseling->date)->format('d/m/Y') }}
                            {{ \Carbon\Carbon::parse($counseling->time)->format('H:i') }}
                        </div>
                    </div>
                </div>

                <div class="p-4">

                    @if($errors->any())
                    <div class="alert rounded-3 mb-4"
                        style="background:rgba(239,68,68,0.15);color:#fca5a5;border:1px solid rgba(239,68,68,0.3);font-size:13px;">
                        ❌ {{ $errors->first() }}
                    </div>
                    @endif

                    <form action="{{ route('counseling.update', $counseling->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Pastor</label>
                            <select name="pastor_id" class="form-select" required>
                                @foreach($pastors as $pastor)
                                <option value="{{ $pastor->id }}"
                                    {{ $counseling->pastor_id == $pastor->id ? 'selected' : '' }}>
                                    {{ $pastor->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="date"
                                class="form-control"
                                value="{{ old('date', $counseling->date) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jam Mulai</label>
                            <input type="time" name="time"
                                class="form-control"
                                value="{{ old('time', \Carbon\Carbon::parse($counseling->time)->format('H:i')) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Durasi</label>
                            <select name="duration" class="form-select">
                                <option value="30" {{ $counseling->duration == 30 ? 'selected' : '' }}>30 Menit</option>
                                <option value="60" {{ $counseling->duration == 60 ? 'selected' : '' }}>60 Menit</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Catatan (opsional)</label>
                            <input type="text" name="note"
                                class="form-control"
                                value="{{ old('note', $counseling->note) }}"
                                placeholder="Misal: Konseling pribadi">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn flex-fill fw-semibold"
                                style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:white;border-radius:10px;border:none;padding:10px;">
                                💾 Simpan
                            </button>
                            <a href="{{ route('counseling.index') }}"
                                class="btn flex-fill"
                                style="background:#0f172a;color:#94a3b8;border:1px solid #334155;border-radius:10px;padding:10px;">
                                ✖ Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
