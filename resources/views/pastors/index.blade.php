@extends('layouts.app')

@section('content')

<style>
    .pastor-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 20px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .pastor-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.4);
    }
    .pastor-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        overflow: hidden;
        border: 2px solid #334155;
    }
    .pastor-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .schedule-badge {
        background: rgba(99,102,241,0.15);
        color: #a5b4fc;
        border: 1px solid rgba(99,102,241,0.3);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        display: inline-block;
    }
    .btn-edit-pastor {
        background: rgba(234,179,8,0.15);
        color: #fbbf24;
        border: 1px solid rgba(234,179,8,0.3);
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 13px;
        transition: 0.2s;
    }
    .btn-edit-pastor:hover {
        background: rgba(234,179,8,0.3);
        color: #fde68a;
    }
    .btn-delete-pastor {
        background: rgba(239,68,68,0.15);
        color: #f87171;
        border: 1px solid rgba(239,68,68,0.3);
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 13px;
        transition: 0.2s;
    }
    .btn-delete-pastor:hover {
        background: rgba(239,68,68,0.3);
        color: #fca5a5;
    }
    .add-card {
        background: #1e293b;
        border: 2px dashed #334155;
        border-radius: 16px;
        padding: 28px;
    }
    .add-card .form-control,
    .add-card .form-select {
        background: #0f172a;
        border: 1px solid #334155;
        color: #e2e8f0;
        border-radius: 10px;
    }
    .add-card .form-control:focus {
        background: #0f172a;
        border-color: #6366f1;
        color: #e2e8f0;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
    }
    .add-card .form-label {
        color: #94a3b8;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .add-card .form-control::placeholder { color: #475569; }
    .modal-content.dark-modal {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 16px;
        color: #e2e8f0;
    }
    .modal-content.dark-modal .form-control {
        background: #0f172a;
        border: 1px solid #334155;
        color: #e2e8f0;
        border-radius: 10px;
    }
    .modal-content.dark-modal .form-control:focus {
        background: #0f172a;
        border-color: #6366f1;
        color: #e2e8f0;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
    }
    .modal-content.dark-modal .form-label {
        color: #94a3b8;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .modal-content.dark-modal .form-control::placeholder { color: #475569; }
    .modal-content.dark-modal .modal-header {
        border-bottom: 1px solid #334155;
    }
    .modal-content.dark-modal .modal-footer {
        border-top: 1px solid #334155;
    }
    .page-header {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 28px;
        border: 1px solid #334155;
    }
    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #475569;
    }
    .empty-state .empty-icon {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.4;
    }
</style>

<div class="container mt-4 pb-5">

    {{-- PAGE HEADER --}}
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-1 fw-bold">⛪ Manajemen Pastor</h3>
            <p class="mb-0 text-secondary" style="font-size:14px;">
                Kelola data pastor dan jadwal ketersediaan konseling
            </p>
        </div>
        <span class="badge rounded-pill"
            style="background:rgba(99,102,241,0.2);color:#a5b4fc;border:1px solid rgba(99,102,241,0.3);font-size:14px;padding:8px 16px;">
            {{ $pastors->count() }} Pastor
        </span>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 mb-4"
        style="background:rgba(34,197,94,0.15);color:#86efac;border:1px solid rgba(34,197,94,0.3) !important;">
        ✅ {{ session('success') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 mb-4"
        style="background:rgba(239,68,68,0.15);color:#fca5a5;border:1px solid rgba(239,68,68,0.3) !important;">
        ❌ {{ session('error') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">

        {{-- ========================
             FORM TAMBAH PASTOR
        ======================== --}}
        <div class="col-lg-4">
            <div class="add-card">
                <h6 class="fw-bold mb-4" style="color:#a5b4fc;">
                    ➕ Tambah Pastor Baru
                </h6>

                @if($errors->any())
                <div class="alert rounded-3 mb-3"
                    style="background:rgba(239,68,68,0.15);color:#fca5a5;border:1px solid rgba(239,68,68,0.3);font-size:13px;">
                    @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form action="{{ route('pastors.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Pastor</label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Contoh: Pastor Budi"
                            value="{{ old('name') }}"
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
                            placeholder="Contoh: Senin - Rabu"
                            value="{{ old('schedule') }}"
                            required>
                        <div class="mt-1" style="font-size:12px;color:#475569;">
                            Misal: Senin – Jumat, Setiap Sabtu, dll.
                        </div>
                        @error('schedule')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn w-100 fw-semibold"
                        style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:white;border-radius:10px;padding:10px;">
                        Simpan Pastor
                    </button>
                </form>
            </div>
        </div>

        {{-- ========================
             DAFTAR PASTOR (CARDS)
        ======================== --}}
        <div class="col-lg-8">

            @if($pastors->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">⛪</div>
                <p class="mb-0">Belum ada data pastor.<br>Tambahkan pastor baru di sebelah kiri.</p>
            </div>
            @else
            <div class="row g-3">
                @foreach($pastors as $pastor)
                <div class="col-md-6">
                    <div class="pastor-card h-100">

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="pastor-avatar">
                                <img src="https://api.dicebear.com/9.x/personas/svg?seed={{ urlencode($pastor->name) }}&backgroundColor=1e293b"
                                     alt="{{ $pastor->name }}"
                                     onerror="this.parentElement.innerHTML='✝️'">
                            </div>
                            <div>
                                <div class="fw-bold" style="font-size:16px;">{{ $pastor->name }}</div>
                                <div style="font-size:12px;color:#64748b;">Pastor Gereja</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <span class="schedule-badge">
                                📅 {{ $pastor->schedule }}
                            </span>
                        </div>

                        <div class="d-flex gap-2">
                            {{-- Tombol Edit → buka modal --}}
                            <button type="button"
                                class="btn-edit-pastor flex-fill"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEdit{{ $pastor->id }}">
                                ✏️ Edit
                            </button>

                            {{-- Tombol Hapus → buka modal konfirmasi --}}
                            <button type="button"
                                class="btn-delete-pastor flex-fill"
                                data-bs-toggle="modal"
                                data-bs-target="#modalHapus{{ $pastor->id }}">
                                🗑️ Hapus
                            </button>
                        </div>

                    </div>
                </div>

                {{-- ===== MODAL EDIT ===== --}}
                <div class="modal fade" id="modalEdit{{ $pastor->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content dark-modal">
                            <div class="modal-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="pastor-avatar" style="width:40px;height:40px;">
                                        <img src="https://api.dicebear.com/9.x/personas/svg?seed={{ urlencode($pastor->name) }}&backgroundColor=1e293b"
                                             alt="{{ $pastor->name }}"
                                             onerror="this.parentElement.innerHTML='✝️'">
                                    </div>
                                    <h6 class="modal-title fw-bold mb-0">✏️ Edit Pastor</h6>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('pastors.update', $pastor->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Pastor</label>
                                        <input type="text"
                                            name="name"
                                            class="form-control"
                                            value="{{ $pastor->name }}"
                                            required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Jadwal Ketersediaan</label>
                                        <input type="text"
                                            name="schedule"
                                            class="form-control"
                                            value="{{ $pastor->schedule }}"
                                            required>
                                        <div class="mt-1" style="font-size:12px;color:#475569;">
                                            Misal: Senin – Jumat, Setiap Sabtu, dll.
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button"
                                        class="btn btn-sm"
                                        style="background:#1e293b;color:#94a3b8;border:1px solid #334155;border-radius:8px;"
                                        data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="btn btn-sm fw-semibold"
                                        style="background:linear-gradient(135deg,#f59e0b,#d97706);color:white;border-radius:8px;border:none;">
                                        💾 Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ===== MODAL HAPUS ===== --}}
                <div class="modal fade" id="modalHapus{{ $pastor->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content dark-modal">
                            <div class="modal-header" style="border-bottom:1px solid rgba(239,68,68,0.3);">
                                <h6 class="modal-title fw-bold" style="color:#f87171;">🗑️ Hapus Pastor</h6>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center py-4">
                                <div class="pastor-avatar mx-auto mb-3" style="width:72px;height:72px;font-size:28px;">
                                    <img src="https://api.dicebear.com/9.x/personas/svg?seed={{ urlencode($pastor->name) }}&backgroundColor=1e293b"
                                         alt="{{ $pastor->name }}"
                                         onerror="this.parentElement.innerHTML='✝️'">
                                </div>
                                <p class="mb-1 fw-semibold">Hapus <span style="color:#f87171;">{{ $pastor->name }}</span>?</p>
                                <p class="mb-0" style="font-size:13px;color:#64748b;">
                                    Semua data konseling terkait pastor ini juga akan ikut terhapus.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-center gap-2">
                                <button type="button"
                                    class="btn btn-sm px-4"
                                    style="background:#1e293b;color:#94a3b8;border:1px solid #334155;border-radius:8px;"
                                    data-bs-dismiss="modal">
                                    Batal
                                </button>
                                <form action="{{ route('pastors.destroy', $pastor->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm px-4 fw-semibold"
                                        style="background:linear-gradient(135deg,#ef4444,#dc2626);color:white;border-radius:8px;border:none;">
                                        Ya, Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
            @endif

        </div>
    </div>
</div>

@endsection
