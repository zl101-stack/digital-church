@extends('layouts.user')

@section('content')

<style>
    .pastor-card {
        background: var(--bg-card);
        border: 1px solid var(--border-md);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .pastor-head {
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 1px solid var(--border);
        background: rgba(99,102,241,0.05);
    }
    .pastor-ava {
        width: 48px; height: 48px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid rgba(99,102,241,0.3);
        flex-shrink: 0;
    }
    .pastor-ava img { width: 100%; height: 100%; object-fit: cover; }
    .pastor-body { padding: 16px; }

    .date-group-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-3);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 8px;
        padding-left: 2px;
    }

    .slot-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid var(--border-md);
        margin-bottom: 8px;
        transition: 0.15s;
        cursor: pointer;
    }
    .slot-row:hover { border-color: var(--accent); background: rgba(99,102,241,0.05); }
    .slot-row.taken  { opacity: 0.4; cursor: not-allowed; }
    .slot-row.mine   { border-color: rgba(34,197,94,0.4); background: rgba(34,197,94,0.05); cursor: default; }
    .slot-row.mine:hover { border-color: rgba(34,197,94,0.4); background: rgba(34,197,94,0.05); }

    .slot-time { font-size: 15px; font-weight: 700; }
    .slot-dur  { font-size: 12px; color: var(--text-2); margin-top: 2px; }
    .slot-note { font-size: 12px; color: var(--text-3); margin-top: 2px; }

    /* Modal */
    .u-modal .modal-content {
        background: #1a2540;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 18px;
        color: var(--text-1);
    }
    .u-modal .modal-header { border-bottom: 1px solid var(--border); padding: 18px 20px; }
    .u-modal .modal-footer { border-top: 1px solid var(--border); padding: 14px 20px; }
    .u-modal .modal-body   { padding: 20px; }
    .u-modal .u-input { background: var(--bg-surface); border: 1px solid rgba(255,255,255,0.1); color: var(--text-1); }
    .u-modal .u-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }
    .u-modal .u-input::placeholder { color: var(--text-3); }

    .booking-info-box {
        background: rgba(99,102,241,0.08);
        border: 1px solid rgba(99,102,241,0.2);
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 16px;
        font-size: 13px;
        color: #a5b4fc;
        line-height: 1.8;
    }

    .history-item {
        background: var(--bg-card);
        border: 1px solid var(--border-md);
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
</style>

{{-- PAGE HEADER --}}
<div class="u-page-header">
    <h2>🧠 Konseling Gereja</h2>
    <p>Pilih slot jadwal yang tersedia untuk booking sesi konseling</p>
</div>

{{-- NOTIF --}}
@if(session('success'))
<div class="u-alert-success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="u-alert-error">❌ {{ session('error') }}</div>
@endif

{{-- JADWAL PER PASTOR --}}
@forelse($pastors as $pastor)
@php $slots = $pastor->counselings->sortBy('date')->sortBy('time'); @endphp
@if($slots->isEmpty()) @continue @endif

<div class="pastor-card">
    <div class="pastor-head">
        <div class="pastor-ava">
            <img src="https://api.dicebear.com/9.x/personas/svg?seed={{ urlencode($pastor->name) }}&backgroundColor=1a2540"
                 alt="{{ $pastor->name }}"
                 onerror="this.style.display='none'">
        </div>
        <div style="flex:1;">
            <div style="font-size:16px;font-weight:700;">{{ $pastor->name }}</div>
            <div style="font-size:12px;color:var(--text-2);">📅 {{ $pastor->schedule }}</div>
        </div>
        <span class="u-badge u-badge-indigo">
            {{ $slots->whereNull('booked_by')->count() }} tersedia
        </span>
    </div>

    <div class="pastor-body">
        @foreach($slots->groupBy('date') as $date => $dateSlots)
        <div class="date-group-label">
            {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
        </div>

        @foreach($dateSlots as $slot)
        @php
            $isMine  = $slot->booked_by == auth()->id();
            $isTaken = $slot->isBooked() && !$isMine;
        @endphp

        <div class="slot-row {{ $isTaken ? 'taken' : ($isMine ? 'mine' : '') }}"
            @if(!$isTaken && !$isMine)
                data-bs-toggle="modal" data-bs-target="#modalBook{{ $slot->id }}"
            @endif>

            <div>
                <div class="slot-time">
                    ⏰ {{ \Carbon\Carbon::parse($slot->time)->format('H:i') }}
                    – {{ \Carbon\Carbon::parse($slot->time)->addMinutes($slot->duration)->format('H:i') }}
                </div>
                <div class="slot-dur">{{ $slot->duration }} menit</div>
                @if($slot->note)
                <div class="slot-note">📝 {{ $slot->note }}</div>
                @endif
            </div>

            <div class="d-flex flex-column align-items-end gap-2">
                @if($isMine)
                    <span class="u-badge u-badge-green">✅ Booking Saya</span>
                    <form action="{{ route('user.counseling.cancel', $slot->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="u-btn u-btn-danger-ghost u-btn-sm"
                            onclick="return confirm('Batalkan booking ini?')">
                            Batalkan
                        </button>
                    </form>
                @elseif($isTaken)
                    <span class="u-badge u-badge-gray">❌ Terisi</span>
                @else
                    <span class="u-badge u-badge-indigo">🟢 Tersedia</span>
                @endif
            </div>
        </div>

        {{-- MODAL BOOKING --}}
        @if(!$isTaken && !$isMine)
        <div class="modal fade u-modal" id="modalBook{{ $slot->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h6 class="modal-title fw-bold mb-0">📅 Konfirmasi Booking</h6>
                            <div style="font-size:12px;color:var(--text-2);">
                                {{ $pastor->name }}
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('user.counseling.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="counseling_id" value="{{ $slot->id }}">
                        <div class="modal-body">
                            <div class="booking-info-box">
                                <div>👤 <strong>{{ $pastor->name }}</strong></div>
                                <div>📅 {{ \Carbon\Carbon::parse($slot->date)->translatedFormat('l, d F Y') }}</div>
                                <div>⏰ {{ \Carbon\Carbon::parse($slot->time)->format('H:i') }} – {{ \Carbon\Carbon::parse($slot->time)->addMinutes($slot->duration)->format('H:i') }} ({{ $slot->duration }} menit)</div>
                            </div>
                            <div class="mb-3">
                                <label class="u-label">Catatan (opsional)</label>
                                <textarea name="booking_note" class="u-input" rows="2"
                                    placeholder="Topik yang ingin dibahas..."></textarea>
                            </div>
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--text-2);">
                                <input type="checkbox" name="is_anonymous" style="accent-color:var(--accent);">
                                Booking sebagai anonim
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="u-btn u-btn-ghost u-btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="u-btn u-btn-primary u-btn-sm">✅ Konfirmasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @endforeach
        @endforeach
    </div>
</div>

@empty
<div class="u-card p-5 text-center" style="color:var(--text-3);">
    <div style="font-size:48px;opacity:0.3;margin-bottom:12px;">🧠</div>
    <p>Belum ada jadwal konseling tersedia.<br>Silakan cek kembali nanti.</p>
</div>
@endforelse

{{-- RIWAYAT --}}
@if($myBookings->isNotEmpty())
<div style="font-size:13px;font-weight:700;color:var(--text-2);text-transform:uppercase;letter-spacing:0.5px;margin:32px 0 14px;">
    📋 Riwayat Booking Saya
</div>
@foreach($myBookings as $b)
<div class="history-item">
    <div>
        <div style="font-weight:700;font-size:15px;">{{ $b->pastor->name ?? '-' }}</div>
        <div style="font-size:13px;color:var(--text-2);margin-top:3px;">
            📅 {{ \Carbon\Carbon::parse($b->date)->translatedFormat('d F Y') }}
            &nbsp;⏰ {{ \Carbon\Carbon::parse($b->time)->format('H:i') }}–{{ \Carbon\Carbon::parse($b->time)->addMinutes($b->duration)->format('H:i') }}
        </div>
        @if($b->booking_note)
        <div style="font-size:12px;color:var(--text-3);margin-top:4px;">💬 {{ $b->booking_note }}</div>
        @endif
    </div>
    <span class="u-badge u-badge-green">✅ Terdaftar</span>
</div>
@endforeach
@endif

@endsection
