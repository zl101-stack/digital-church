@extends('layouts.app')

@section('content')

<style>
    .edit-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 16px;
        overflow: hidden;
    }
    .edit-card .form-control {
        background: #0f172a;
        border: 1px solid #334155;
        color: #e2e8f0;
        border-radius: 10px;
    }
    .edit-card .form-control:focus {
        background: #0f172a;
        border-color: #6366f1;
        color: #e2e8f0;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
    }
    .edit-card .form-label {
        color: #94a3b8;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .edit-card .form-control::placeholder { color: #475569; }
</style>

<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="edit-card shadow">

                {{-- HEADER --}}
                <div class="px-4 py-3 d-flex align-items-center gap-3"
                    style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                    <div style="font-size:24px;">✏️</div>
                    <div>
                        <div class="fw-bold text-white" style="font-size:16px;">Edit Data Pastor</div>
                        <div style="font-size:12px;color:rgba(255,255,255,0.75);">{{ $pastor->name }}</div>
                    </div>
                </div>

                <div class="p-4">

                    @if($errors->any())
                    <div class="alert rounded-3 mb-4"
                        style="background:rgba(239,68,68,0.15);color:#fca5a5;border:1px solid rgba(239,68,68,0.3);font-size:13px;">
                        @foreach($errors->all() as $error)
                        <div>• {{ $error }}</div>
                        @endforeach
                    </div>
                    @endif

                    <form action="{{ route('pastors.update', $pastor->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Pastor</label>
                            <input type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $pastor->name) }}"
                                required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Jadwal Ketersediaan</label>
                            <input type="text"
                                name="schedule"
                                class="form-control @error('schedule') is-invalid @enderror"
                                value="{{ old('schedule', $pastor->schedule) }}"
                                required>
                            <div class="mt-1" style="font-size:12px;color:#475569;">
                                Misal: Senin – Jumat, Setiap Sabtu, dll.
                            </div>
                            @error('schedule')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn flex-fill fw-semibold"
                                style="background:linear-gradient(135deg,#f59e0b,#d97706);color:white;border-radius:10px;border:none;padding:10px;">
                                💾 Simpan Perubahan
                            </button>
                            <a href="{{ route('pastors.index') }}"
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
