@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">💒 Donasi Gereja</h2>

    <!-- FORM DONASI -->
    <div class="card mb-4 shadow">
        <div class="card-body">
            <form action="/donations" method="POST">
                @csrf

                <input type="number" name="amount" class="form-control mb-2" placeholder="Jumlah Donasi" required>

                <input type="date" name="date" class="form-control mb-2" required>

                <textarea name="note" class="form-control mb-2" placeholder="Catatan (opsional)"></textarea>

                <!-- CHECKBOX -->
                <div class="form-check mb-3">
                    <input type="checkbox" name="is_anonymous" class="form-check-input" value="1" id="anonim">
                    <label class="form-check-label" for="anonim">
                        Donasi sebagai Anonim
                    </label>
                </div>

                <button class="btn btn-success w-100">Tambah Donasi</button>
            </form>
        </div>
    </div>

    <!-- FILTER TANGGAL + EXPORT (superadmin only) -->
    <div class="card mb-4 shadow">
        <div class="card-body">
            <form method="GET" action="{{ route('donations.index') }}" class="row g-2 align-items-end">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">📅 Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control"
                        value="{{ $startDate ?? '' }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">📅 Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control"
                        value="{{ $endDate ?? '' }}">
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        🔍 Filter
                    </button>
                    <a href="{{ route('donations.index') }}" class="btn btn-outline-secondary w-100">
                        ✖ Reset
                    </a>
                </div>

            </form>

            @if(auth()->user()->role === 'superadmin')
            <hr>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small">Export data yang sedang ditampilkan:</span>
                <a href="{{ route('donations.export', ['start_date' => $startDate ?? '', 'end_date' => $endDate ?? '']) }}"
                    class="btn btn-success">
                    📥 Export Excel
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- TOTAL -->
    <div class="alert alert-info">
        💰 Total Donasi{{ ($startDate || $endDate) ? ' (Terfilter)' : '' }}:
        <strong>Rp {{ number_format($total) }}</strong>
    </div>

    <!-- TABLE DONASI -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Donatur</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $i => $donation)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            @if($donation->is_anonymous)
                                <span class="badge bg-secondary">Anonim</span>
                            @else
                                {{ $donation->user->name ?? 'User' }}
                            @endif
                        </td>

                        <td><strong>Rp {{ number_format($donation->amount) }}</strong></td>
                        <td>
                            @if(($donation->payment_method ?? 'manual') === 'qris')
                                <span class="badge bg-success">📱 QRIS</span>
                            @else
                                <span class="badge bg-primary">💳 Manual</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($donation->date)->format('d/m/Y') }}</td>
                        <td>{{ $donation->note ?? '-' }}</td>

                        <td>
                            <a href="/donations/{{ $donation->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/donations/{{ $donation->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus donasi ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Belum ada data donasi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
