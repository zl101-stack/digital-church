@extends('layouts.app')

@section('content')

<style>
    .slot-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 14px;
        padding: 16px 20px;
        transition: 0.2s;
    }
    .slot-card:hover {
        border-color: #6366f1;
        box-shadow: 0 4px 20px rgba(99,102,241,0.15);
    }
    .slot-booked {
        border-color: rgba(34,197,94,0.4);
        background: rgba(34,197,94,0.05);
    }
    .slot-available {
        border-color: rgba(99,102,241,0.3);
    }
    .badge-booked {
        background: rgba(34,197,94,0.15);
        color: #86efac;
        border: 1px solid rgba(34,197,94,0.3);
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 11px;
    }
    .badge-available {
        background: rgba(99,102,241,0.15);
        color: #a5b4fc;
        border: 1px solid rgba(99,102,241,0.3);
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 11px;
    }
    .form-panel {
        background: #1e293b;
        border: 2px dashed #334155;
        border-radius: 16px;
        padding: 24px;
    }
    .form-panel .form-control,
    .form-panel .form-select {
        background: #0f172a;
        border: 1px solid #334155;
        color: #e2e8f0;
        border-radius: 10px;
    }
    .form-panel .form-control:focus,
    .form-panel .form-select:focus {
        background: #0f172a;
        border-color: #6366f1;
        color: #e2e8f0;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
    }
    .form-panel .form-label {
        color: #94a3b8;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-panel .form-control::placeholder,
    .form-panel .form-select option { color: #475569; }
    .page-header {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        border-radius: 16px;
        padding: 22px 28px;
        margin-bottom: 28px;
        border: 1px solid #334155;
    }
</style>

<div class="container mt-4 pb-5">

    {{-- PAGE HEADER --}}
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 fw-bold">🗓️ Manajemen Jadwal Konseling</h3>
            <p class="mb-0 text-secondary" style="font-size:14px;">
                Buat slot jadwal konseling yang bisa dipilih oleh jemaat
            </p>
        </div>
        <div class="text-end">
            <span class="badge rounded-pill me-1"
                style="background:rgba(99,102,241,0.2);color:#a5b4fc;border:1px solid rgba(99,102,241,0.3);font-size:13px;padding:7px 14px;">
                {{ $slots->where('booked_by', null)->count() }} Tersedia
            </span>
            <span class="badge rounded-pill"
                style="background:rgba(34,197,94,0.2);color:#86efac;border:1px solid rgba(34,197,94,0.3);font-size:13px;padding:7px 14px;">
                {{ $slots->whereNotNull('booked_by')->count() }} Terisi
            </span>
        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
    <div class="alert alert-dismissible fade show rounded-3 mb-4"
        style="background:rgba(34,197,94,0.15);color:#86efac;border:1px solid rgba(34,197,94,0.3);">
        ✅ {{ session('success') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-dismissible fade show rounded-3 mb-4"
        style="background:rgba(239,68,68,0.15);color:#fca5a5;border:1px solid rgba(239,68,68,0.3);">
        ❌ {{ $errors->first() }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">

        {{-- ========================
             FORM TAMBAH SLOT
        ======================== --}}
        <div class="col-lg-4">
            <div class="form-panel">
                <h6 class="fw-bold mb-4" style="color:#a5b4fc;">➕ Tambah Slot Jadwal</h6>

                <form action="{{ route('counseling.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Pastor</label>
                        <select name="pastor_id" class="form-select" required>
                            <option value="">-- Pilih Pastor --</option>
                            @foreach($pastors as $pastor)
                            <option value="{{ $pastor->id }}" {{ old('pastor_id') == $pastor->id ? 'selected' : '' }}>
                                {{ $pastor->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="date"
                            class="form-control"
                            value="{{ old('date') }}"
                            min="{{ date('Y-m-d') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="time"
                            class="form-control"
                            value="{{ old('time') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Durasi</label>
                        <select name="duration" class="form-select">
                            <option value="30" {{ old('duration') == 30 ? 'selected' : '' }}>30 Menit</option>
                            <option value="60" {{ old('duration') == 60 ? 'selected' : '' }}>60 Menit</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Catatan (opsional)</label>
                        <input type="text" name="note"
                            class="form-control"
                            placeholder="Misal: Konseling pribadi"
                            value="{{ old('note') }}">
                    </div>

                    <button type="submit" class="btn w-100 fw-semibold"
                        style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:white;border-radius:10px;padding:10px;border:none;">
                        Simpan Slot
                    </button>
                </form>
            </div>
        </div>

        {{-- ========================
             DAFTAR SLOT
        ======================== --}}
        <div class="col-lg-8">

            @if($slots->isEmpty())
            <div class="text-center py-5" style="color:#475569;">
                <div style="font-size:48px;opacity:0.3;">🗓️</div>
                <p class="mt-2">Belum ada slot jadwal. Tambahkan slot di sebelah kiri.</p>
            </div>
            @else

            {{-- Group by tanggal --}}
            @foreach($slots->groupBy('date') as $date => $dateSlots)
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div style="width:4px;height:20px;background:linear-gradient(#6366f1,#8b5cf6);border-radius:4px;"></div>
                    <span class="fw-semibold" style="color:#e2e8f0;">
                        📅 {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
                    </span>
                    <span style="font-size:12px;color:#475569;">({{ $dateSlots->count() }} slot)</span>
                </div>

                <div class="row g-2">
                    @foreach($dateSlots as $slot)
                    <div class="col-md-6">
                        <div class="slot-card {{ $slot->isBooked() ? 'slot-booked' : 'slot-available' }}">

                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="fw-semibold" style="font-size:15px;">
                                        {{ $slot->pastor->name ?? '-' }}
                                    </div>
                                    <div style="font-size:13px;color:#64748b;">
                                        ⏰ {{ \Carbon\Carbon::parse($slot->time)->format('H:i') }}
                                        –
                                        {{ \Carbon\Carbon::parse($slot->time)->addMinutes($slot->duration)->format('H:i') }}
                                        <span style="color:#475569;">({{ $slot->duration }} mnt)</span>
                                    </div>
                                </div>
                                @if($slot->isBooked())
                                <span class="badge-booked">✅ Terisi</span>
                                @else
                                <span class="badge-available">🟢 Tersedia</span>
                                @endif
                            </div>

                            @if($slot->isBooked())
                            <div class="mb-2 p-2 rounded-2" style="background:rgba(34,197,94,0.08);font-size:12px;color:#86efac;">
                                👤 {{ $slot->bookedByUser->name ?? 'Anonim' }}
                                @if($slot->booking_note)
                                <br>💬 {{ $slot->booking_note }}
                                @endif
                            </div>
                            @endif

                            @if($slot->note)
                            <div style="font-size:12px;color:#64748b;" class="mb-2">
                                📝 {{ $slot->note }}
                            </div>
                            @endif

                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ route('counseling.edit', $slot->id) }}"
                                    class="btn btn-sm flex-fill"
                                    style="background:rgba(234,179,8,0.15);color:#fbbf24;border:1px solid rgba(234,179,8,0.3);border-radius:8px;font-size:12px;">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('counseling.destroy', $slot->id) }}" method="POST" class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm w-100"
                                        style="background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.3);border-radius:8px;font-size:12px;"
                                        onclick="return confirm('Hapus slot ini?')">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            @endif
        </div>

    </div>
</div>

@endsection
