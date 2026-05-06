@extends('layouts.user')

@section('content')

<style>
    .method-tabs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 24px;
    }
    .method-tab {
        padding: 14px;
        border-radius: 12px;
        border: 2px solid var(--border-md);
        background: var(--bg-card);
        color: var(--text-2);
        text-align: center;
        cursor: pointer;
        transition: 0.18s;
        font-weight: 600;
        font-size: 14px;
        user-select: none;
    }
    .method-tab:hover { border-color: var(--accent); color: #a5b4fc; }
    .method-tab.active {
        border-color: var(--accent);
        background: rgba(99,102,241,0.1);
        color: #a5b4fc;
    }
    .method-tab.active.qris-tab {
        border-color: var(--green);
        background: rgba(34,197,94,0.08);
        color: #86efac;
    }

    .panel { display: none; }
    .panel.active { display: block; }

    .chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 10px; }
    .chip {
        padding: 7px 16px;
        border-radius: 20px;
        border: 1px solid var(--border-md);
        background: var(--bg-surface);
        color: var(--text-2);
        font-size: 13px;
        cursor: pointer;
        transition: 0.15s;
        font-weight: 500;
    }
    .chip:hover, .chip.selected {
        border-color: var(--green);
        background: rgba(34,197,94,0.1);
        color: #86efac;
    }

    .qris-wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }
    .qris-card {
        background: white;
        border-radius: 18px;
        padding: 18px;
        text-align: center;
        width: 240px;
        box-shadow: 0 8px 40px rgba(0,0,0,0.5);
    }
    .qris-card img { width: 100%; border-radius: 8px; }
    .qris-card .qris-label {
        background: linear-gradient(135deg, #ef4444, #f97316);
        color: white;
        font-weight: 800;
        font-size: 12px;
        letter-spacing: 2px;
        padding: 5px 0;
        border-radius: 6px;
        margin-top: 10px;
    }
    .qris-card .qris-name {
        font-size: 12px;
        color: #334155;
        font-weight: 700;
        margin-top: 5px;
    }

    .steps-box {
        background: rgba(99,102,241,0.06);
        border: 1px solid rgba(99,102,241,0.15);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
    }
    .steps-box .steps-title {
        font-size: 12px;
        font-weight: 700;
        color: #a5b4fc;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .step-row {
        display: flex;
        gap: 12px;
        margin-bottom: 10px;
        align-items: flex-start;
    }
    .step-num {
        width: 24px; height: 24px;
        border-radius: 50%;
        background: rgba(34,197,94,0.15);
        border: 1px solid rgba(34,197,94,0.3);
        color: #86efac;
        font-size: 12px;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .step-text { font-size: 13px; color: #cbd5e1; padding-top: 3px; }

    .amount-preview {
        background: rgba(34,197,94,0.08);
        border: 1px solid rgba(34,197,94,0.2);
        border-radius: 12px;
        padding: 14px;
        text-align: center;
        margin-bottom: 16px;
        display: none;
    }
    .amount-preview.show { display: block; }
    .amount-preview .val { font-size: 24px; font-weight: 800; color: #86efac; }

    .bank-info {
        background: var(--bg-card);
        border: 1px solid var(--border-md);
        border-radius: 14px;
        padding: 18px;
        margin-top: 20px;
    }
    .bank-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid var(--border);
        font-size: 14px;
    }
    .bank-row:last-child { border-bottom: none; }
    .bank-row .lbl { color: var(--text-2); }
    .bank-row .val { font-weight: 600; }

    .form-section { margin-bottom: 18px; }
    .anon-check {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 14px;
        color: var(--text-2);
    }
    .anon-check input { accent-color: var(--green); width: 16px; height: 16px; }
</style>

{{-- PAGE HEADER --}}
<div class="u-page-header">
    <h2>💖 Donasi Gereja</h2>
    <p>Berkatilah pelayanan melalui donasi terbaikmu</p>
</div>

{{-- NOTIF --}}
@if(session('success'))
<div class="u-alert-success">🙏 {{ session('success') }}</div>
@endif
@if($errors->any())
<div class="u-alert-error">❌ {{ $errors->first() }}</div>
@endif

<div class="row g-4">

    {{-- FORM DONASI --}}
    <div class="col-lg-7">
        <div class="u-card p-4">

            {{-- TAB --}}
            <div class="method-tabs">
                <div class="method-tab active" id="tab-manual" onclick="switchTab('manual')">
                    💳 Transfer / Tunai
                </div>
                <div class="method-tab qris-tab" id="tab-qris" onclick="switchTab('qris')">
                    📱 QRIS
                </div>
            </div>

            {{-- PANEL MANUAL --}}
            <div class="panel active" id="panel-manual">
                <form method="POST" action="{{ route('user.donation.store') }}">
                    @csrf
                    <input type="hidden" name="payment_method" value="manual">

                    <div class="form-section">
                        <label class="u-label">Jumlah Donasi</label>
                        <div class="chips">
                            @foreach([50000,100000,200000,500000] as $n)
                            <span class="chip" onclick="setNominal({{ $n }}, this, 'amount-manual')">
                                Rp {{ number_format($n,0,',','.') }}
                            </span>
                            @endforeach
                        </div>
                        <input type="number" name="amount" id="amount-manual"
                            class="u-input" placeholder="Atau ketik nominal lain..." min="1000" required>
                        <div style="font-size:12px;color:var(--text-3);margin-top:5px;">Minimal Rp 1.000</div>
                    </div>

                    <div class="form-section">
                        <label class="u-label">Catatan</label>
                        <textarea name="note" class="u-input" rows="3"
                            placeholder="Contoh: Persembahan Minggu / Donasi Pembangunan"></textarea>
                    </div>

                    <div class="form-section">
                        <label class="anon-check">
                            <input type="checkbox" name="is_anonymous">
                            Donasi sebagai anonim
                        </label>
                    </div>

                    <button type="submit" class="u-btn u-btn-green u-btn-full" style="padding:13px;">
                        💖 Kirim Donasi
                    </button>
                </form>
            </div>

            {{-- PANEL QRIS --}}
            <div class="panel" id="panel-qris">

                <div class="form-section">
                    <label class="u-label">Nominal Donasi</label>
                    <div class="chips">
                        @foreach([50000,100000,200000,500000] as $n)
                        <span class="chip" onclick="setNominalQris({{ $n }}, this)">
                            Rp {{ number_format($n,0,',','.') }}
                        </span>
                        @endforeach
                    </div>
                    <input type="number" id="amount-qris-input" class="u-input"
                        placeholder="Atau ketik nominal lain..." min="1000"
                        oninput="updatePreview(this.value)">
                    <div style="font-size:12px;color:var(--text-3);margin-top:5px;">Minimal Rp 1.000</div>
                </div>

                <div class="amount-preview" id="amount-preview">
                    <div style="font-size:12px;color:var(--text-2);margin-bottom:4px;">Nominal Donasi</div>
                    <div class="val" id="preview-val">Rp 0</div>
                </div>

                <div class="qris-wrapper">
                    <div class="qris-card">
                        @if(file_exists(public_path('images/qris.png')))
                            <img src="{{ asset('images/qris.png') }}" alt="QRIS">
                        @else
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=GEREJA-DIGITAL-QRIS&margin=10"
                                 alt="QRIS" style="width:200px;height:200px;">
                        @endif
                        <div class="qris-label">QRIS</div>
                        <div class="qris-name">Gereja Digital</div>
                    </div>
                </div>

                <div class="steps-box">
                    <div class="steps-title">📱 Cara Bayar via QRIS</div>
                    <div class="step-row">
                        <div class="step-num">1</div>
                        <div class="step-text">Buka aplikasi dompet digital (GoPay, OVO, Dana, ShopeePay, m-Banking)</div>
                    </div>
                    <div class="step-row">
                        <div class="step-num">2</div>
                        <div class="step-text">Pilih menu <strong style="color:#e2e8f0;">Scan QR</strong> lalu scan kode di atas</div>
                    </div>
                    <div class="step-row">
                        <div class="step-num">3</div>
                        <div class="step-text">Masukkan nominal dan selesaikan pembayaran</div>
                    </div>
                    <div class="step-row" style="margin-bottom:0;">
                        <div class="step-num">4</div>
                        <div class="step-text">Klik <strong style="color:#86efac;">Konfirmasi Donasi</strong> di bawah</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('user.donation.store') }}" id="form-qris">
                    @csrf
                    <input type="hidden" name="payment_method" value="qris">
                    <input type="hidden" name="amount" id="amount-qris-hidden">

                    <div class="form-section">
                        <label class="u-label">Catatan</label>
                        <textarea name="note" class="u-input" rows="2"
                            placeholder="Contoh: Persembahan Minggu"></textarea>
                    </div>

                    <div class="form-section">
                        <label class="anon-check">
                            <input type="checkbox" name="is_anonymous">
                            Donasi sebagai anonim
                        </label>
                    </div>

                    <button type="button" onclick="submitQris()" class="u-btn u-btn-green u-btn-full" style="padding:13px;">
                        ✅ Sudah Bayar — Konfirmasi Donasi
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- INFO REKENING --}}
    <div class="col-lg-5">
        <div class="u-card p-4 mb-4">
            <div style="font-size:13px;font-weight:700;color:var(--text-2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:16px;">
                🏦 Info Rekening Transfer
            </div>
            <div class="bank-row">
                <span class="lbl">Bank</span>
                <span class="val">BCA / BNI / Mandiri</span>
            </div>
            <div class="bank-row">
                <span class="lbl">No. Rekening</span>
                <span class="val">1234-5678-9012</span>
            </div>
            <div class="bank-row">
                <span class="lbl">Atas Nama</span>
                <span class="val">Gereja Digital</span>
            </div>
        </div>

        <div class="u-card p-4" style="background:rgba(99,102,241,0.06);border-color:rgba(99,102,241,0.2);">
            <div style="font-size:13px;font-weight:700;color:#a5b4fc;margin-bottom:12px;">
                💡 Tentang Donasi
            </div>
            <p style="font-size:13px;color:var(--text-2);line-height:1.7;margin:0;">
                Setiap donasi yang kamu berikan akan digunakan untuk mendukung pelayanan gereja,
                pembangunan fasilitas, dan program sosial jemaat. Tuhan memberkati setiap
                pemberi yang memberi dengan sukacita. 🙏
            </p>
        </div>
    </div>

</div>

<script>
    function switchTab(m) {
        document.querySelectorAll('.method-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
        document.getElementById('tab-' + m).classList.add('active');
        document.getElementById('panel-' + m).classList.add('active');
    }
    function setNominal(val, el, inputId) {
        document.getElementById(inputId).value = val;
        el.closest('.chips').querySelectorAll('.chip').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
    }
    function setNominalQris(val, el) {
        document.getElementById('amount-qris-input').value = val;
        document.getElementById('amount-qris-hidden').value = val;
        el.closest('.chips').querySelectorAll('.chip').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        updatePreview(val);
    }
    function updatePreview(val) {
        document.getElementById('amount-qris-hidden').value = val;
        const box = document.getElementById('amount-preview');
        const txt = document.getElementById('preview-val');
        if (val && parseInt(val) >= 1000) {
            txt.textContent = 'Rp ' + parseInt(val).toLocaleString('id-ID');
            box.classList.add('show');
        } else {
            box.classList.remove('show');
        }
    }
    function submitQris() {
        const amount = document.getElementById('amount-qris-hidden').value;
        if (!amount || parseInt(amount) < 1000) {
            alert('Masukkan nominal donasi terlebih dahulu (minimal Rp 1.000)');
            return;
        }
        if (!confirm('Pastikan kamu sudah menyelesaikan pembayaran QRIS sebesar Rp ' +
            parseInt(amount).toLocaleString('id-ID') + '.\n\nLanjutkan konfirmasi?')) return;
        document.getElementById('form-qris').submit();
    }
</script>

@endsection
