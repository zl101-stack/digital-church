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

    <!-- TABLE DONASI -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Donatur</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                    <tr>
                        <td>
                            @if($donation->is_anonymous)
                                <span class="badge bg-secondary">Anonim</span>
                            @else
                                {{ $donation->user->name ?? 'User' }}
                            @endif
                        </td>

                        <td><strong>Rp {{ number_format($donation->amount) }}</strong></td>
                        <td>{{ $donation->date }}</td>
                        <td>{{ $donation->note }}</td>

                        <td>
                            <a href="/donations/{{ $donation->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/donations/{{ $donation->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus donasi ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    @if($donations->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Belum ada data donasi
                        </td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection