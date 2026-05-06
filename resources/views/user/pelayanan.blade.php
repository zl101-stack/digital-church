@extends('layouts.user')

@section('content')

<style>
    .service-card {
        background: var(--bg-card);
        border: 1px solid var(--border-md);
        border-radius: 16px;
        padding: 20px;
        cursor: pointer;
        transition: 0.2s;
        height: 100%;
    }
    .service-card:hover {
        border-color: var(--accent);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(99,102,241,0.15);
    }
    .service-card h5 { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
    .service-card .meta { font-size: 13px; color: var(--text-2); display: flex; align-items: center; gap: 6px; margin-top: 5px; }

    .slot-bar {
        height: 6px;
        background: rgba(255,255,255,0.06);
        border-radius: 10px;
        margin: 14px 0 10px;
        overflow: hidden;
    }
    .slot-bar-fill {
        height: 100%;
        border-radius: 10px;
        background: linear-gradient(to right, var(--accent), var(--accent-2));
        transition: width 0.4s;
    }

    .team-card {
        background: var(--bg-card);
        border: 1px solid var(--border-md);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 14px;
    }
    .team-card-header {
        padding: 14px 18px;
        background: rgba(99,102,241,0.07);
        border-bottom: 1px solid var(--border);
        font-weight: 700;
        font-size: 15px;
    }
    .team-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 18px;
        border-bottom: 1px solid var(--border);
        font-size: 14px;
    }
    .team-row:last-child { border-bottom: none; }
    .pos-chip {
        background: rgba(99,102,241,0.12);
        color: #a5b4fc;
        border: 1px solid rgba(99,102,241,0.2);
        border-radius: 8px;
        padding: 3px 10px;
        font-size: 12px;
        font-weight: 600;
    }

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

    .pos-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid var(--border-md);
        margin-bottom: 8px;
        cursor: pointer;
        transition: 0.15s;
    }
    .pos-option:has(input:checked) {
        border-color: var(--accent);
        background: rgba(99,102,241,0.1);
    }
    .pos-option.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }
    .pos-option input[type=radio] { display: none; }
</style>

{{-- PAGE HEADER --}}
<div class="u-page-header">
    <h2>🙌 Pelayanan Gereja</h2>
    <p>Daftarkan dirimu untuk melayani dalam ibadah</p>
</div>

{{-- NOTIF --}}
@if(session('error'))
<div class="u-alert-error">❌ {{ session('error') }}</div>
@endif
@if(session('success'))
<div class="u-alert-success">✅ {{ session('success') }}</div>
@endif

@php
$positions = [
    'Vokalis',
    'Gitar',
    'Drummer',
    'Sound System',
    'Multimedia',
];
@endphp

{{-- JADWAL TERSEDIA --}}
<div style="font-size:13px;font-weight:700;color:var(--text-2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:14px;">
    📅 Jadwal Tersedia
</div>

<div class="row g-3 mb-5">
    @forelse($services as $service)
    @php
        $total = count($service->registrations);
        $alreadyRegistered = $service->registrations->where('user_id', auth()->id())->count();
        $pct = min(100, ($total / 5) * 100);
    @endphp

    <div class="col-md-6">
        <div class="service-card"
            data-bs-toggle="modal"
            data-bs-target="#modalService{{ $service->id }}">

            <div class="d-flex justify-content-between align-items-start mb-2">
                <h5>{{ $service->title }}</h5>
                @if($alreadyRegistered)
                    <span class="u-badge u-badge-green">✅ Terdaftar</span>
                @else
                    <span class="u-badge u-badge-indigo">🟢 Open</span>
                @endif
            </div>

            <div class="meta">📍 {{ $service->location }}</div>
            <div class="meta">📅 {{ \Carbon\Carbon::parse($service->date)->translatedFormat('d F Y') }}</div>
            <div class="meta">⏰ {{ $service->time }} WIB</div>

            <div class="slot-bar">
                <div class="slot-bar-fill" style="width:{{ $pct }}%"></div>
            </div>
            <div style="font-size:12px;color:var(--text-2);">{{ $total }}/5 posisi terisi</div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade u-modal" id="modalService{{ $service->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h6 class="modal-title fw-bold mb-0">{{ $service->title }}</h6>
                        <div style="font-size:12px;color:var(--text-2);">
                            📅 {{ \Carbon\Carbon::parse($service->date)->translatedFormat('d F Y') }}
                            &nbsp;⏰ {{ $service->time }}
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('user.pelayanan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <input type="hidden" name="name" value="{{ auth()->user()->name }}">

                    <div class="modal-body">
                        @if($alreadyRegistered)
                        <div class="u-alert-success mb-3">
                            ✅ Kamu sudah terdaftar di jadwal ini
                        </div>
                        @endif

                        @php $taken = $service->registrations->pluck('position')->toArray(); @endphp

                        <div style="font-size:12px;color:var(--text-2);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:12px;">
                            Pilih Posisi
                        </div>

                        @foreach($positions as $pos)
                        @php $isTaken = in_array($pos, $taken); @endphp
                        <label class="pos-option {{ ($isTaken || $alreadyRegistered) ? 'disabled' : '' }}">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <input type="radio" name="position" value="{{ $pos }}"
                                    {{ ($isTaken || $alreadyRegistered) ? 'disabled' : '' }}>
                                <span style="font-size:14px;font-weight:500;">{{ $pos }}</span>
                            </div>
                            @if($isTaken)
                                <span class="u-badge u-badge-red" style="font-size:11px;">Terisi</span>
                            @elseif($alreadyRegistered)
                                <span class="u-badge u-badge-gray" style="font-size:11px;">Terkunci</span>
                            @else
                                <span class="u-badge u-badge-green" style="font-size:11px;">Tersedia</span>
                            @endif
                        </label>
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="u-btn u-btn-ghost u-btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="u-btn u-btn-primary u-btn-sm"
                            {{ $alreadyRegistered ? 'disabled' : '' }}>
                            Simpan Pelayanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @empty
    <div class="col-12">
        <div class="u-card p-5 text-center" style="color:var(--text-3);">
            <div style="font-size:40px;opacity:0.3;margin-bottom:10px;">📅</div>
            <p>Belum ada jadwal pelayanan tersedia.</p>
        </div>
    </div>
    @endforelse
</div>

{{-- TIM PELAYANAN --}}
<div style="font-size:13px;font-weight:700;color:var(--text-2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:14px;">
    👥 Tim Pelayanan
</div>

@foreach($services as $service)
<div class="team-card">
    <div class="team-card-header">{{ $service->title }}
        <span style="font-size:12px;color:var(--text-2);font-weight:400;margin-left:8px;">
            {{ \Carbon\Carbon::parse($service->date)->translatedFormat('d F Y') }}
        </span>
    </div>
    @forelse($service->registrations as $reg)
    <div class="team-row">
        <span>{{ $reg->name }}</span>
        <span class="pos-chip">{{ $reg->position }}</span>
    </div>
    @empty
    <div class="team-row" style="color:var(--text-3);justify-content:center;">
        Belum ada pelayan terdaftar
    </div>
    @endforelse
</div>
@endforeach

<script>
    // Klik label pos-option untuk select radio
    document.querySelectorAll('.pos-option:not(.disabled)').forEach(el => {
        el.addEventListener('click', () => {
            const radio = el.querySelector('input[type=radio]');
            if (radio && !radio.disabled) radio.checked = true;
        });
    });
</script>

@endsection
