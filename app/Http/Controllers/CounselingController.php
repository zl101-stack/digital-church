<?php

namespace App\Http\Controllers;

use App\Models\Counseling;
use App\Models\Pastor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CounselingController extends Controller
{
    // =============================================
    //  ADMIN / SUPERADMIN — Kelola Slot Jadwal
    // =============================================

    /** Tampil semua slot + form tambah slot */
    public function index()
    {
        $slots   = Counseling::with('pastor', 'bookedByUser')
                    ->where('is_slot', true)
                    ->orderBy('date')
                    ->orderBy('time')
                    ->get();
        $pastors = Pastor::all();

        return view('counselings.index', compact('slots', 'pastors'));
    }

    /** Simpan slot baru (admin/superadmin) */
    public function store(Request $request)
    {
        $request->validate([
            'pastor_id' => 'required|exists:pastors,id',
            'date'      => 'required|date|after_or_equal:today',
            'time'      => 'required',
            'duration'  => 'required|in:30,60',
            'note'      => 'nullable|string|max:255',
        ], [
            'date.after_or_equal' => 'Tanggal tidak boleh di masa lalu.',
        ]);

        $time = date('H:i:s', strtotime($request->time));

        // Cek bentrok slot pada pastor + tanggal + jam yang sama
        $bentrok = $this->cekBentrok($request->pastor_id, $request->date, $time, $request->duration);

        if ($bentrok) {
            return back()
                ->withErrors(['time' => 'Jam ini bentrok dengan slot lain pada pastor yang sama.'])
                ->withInput();
        }

        Counseling::create([
            'pastor_id' => $request->pastor_id,
            'date'      => $request->date,
            'time'      => $time,
            'duration'  => $request->duration,
            'note'      => $request->note,
            'is_slot'   => true,
            'user_id'   => null,
            'booked_by' => null,
        ]);

        return redirect()->route('counseling.index')
            ->with('success', 'Slot jadwal berhasil ditambahkan.');
    }

    /** Form edit slot */
    public function edit($id)
    {
        $counseling = Counseling::where('is_slot', true)->findOrFail($id);
        $pastors    = Pastor::all();

        return view('counselings.edit', compact('counseling', 'pastors'));
    }

    /** Update slot */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pastor_id' => 'required|exists:pastors,id',
            'date'      => 'required|date',
            'time'      => 'required',
            'duration'  => 'required|in:30,60',
            'note'      => 'nullable|string|max:255',
        ]);

        $time    = date('H:i:s', strtotime($request->time));
        $bentrok = $this->cekBentrok($request->pastor_id, $request->date, $time, $request->duration, $id);

        if ($bentrok) {
            return back()
                ->withErrors(['time' => 'Jam ini bentrok dengan slot lain pada pastor yang sama.'])
                ->withInput();
        }

        $counseling = Counseling::findOrFail($id);
        $counseling->update([
            'pastor_id' => $request->pastor_id,
            'date'      => $request->date,
            'time'      => $time,
            'duration'  => $request->duration,
            'note'      => $request->note,
        ]);

        return redirect()->route('counseling.index')
            ->with('success', 'Slot jadwal berhasil diperbarui.');
    }

    /** Hapus slot */
    public function destroy($id)
    {
        Counseling::findOrFail($id)->delete();
        return back()->with('success', 'Slot jadwal berhasil dihapus.');
    }

    // =============================================
    //  USER — Lihat & Booking Slot
    // =============================================

    /** Halaman konseling user */
    public function userView()
    {
        $pastors = Pastor::with(['counselings' => function ($q) {
            $q->where('is_slot', true)
              ->whereDate('date', '>=', today())
              ->orderBy('date')
              ->orderBy('time');
        }])->get();

        // Riwayat booking milik user ini
        $myBookings = Counseling::with('pastor')
            ->where('is_slot', true)
            ->where('booked_by', auth()->id())
            ->orderByDesc('date')
            ->get();

        return view('user.counseling', compact('pastors', 'myBookings'));
    }

    /** User booking slot */
    public function userStore(Request $request)
    {
        $request->validate([
            'counseling_id' => 'required|exists:counselings,id',
            'booking_note'  => 'nullable|string|max:255',
        ]);

        $slot = Counseling::where('is_slot', true)->findOrFail($request->counseling_id);

        // Cek sudah diambil
        if ($slot->isBooked()) {
            return back()->with('error', 'Maaf, slot ini sudah diambil orang lain.');
        }

        // Cek user sudah punya booking di pastor + tanggal yang sama
        $sudahBooking = Counseling::where('is_slot', true)
            ->where('booked_by', auth()->id())
            ->where('pastor_id', $slot->pastor_id)
            ->whereDate('date', $slot->date)
            ->exists();

        if ($sudahBooking) {
            return back()->with('error', 'Kamu sudah memiliki booking dengan pastor ini pada tanggal tersebut.');
        }

        $slot->update([
            'booked_by'    => auth()->id(),
            'booking_note' => $request->booking_note,
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        return back()->with('success', 'Booking berhasil! Sampai jumpa di sesi konseling.');
    }

    /** User batalkan booking */
    public function userCancel($id)
    {
        $slot = Counseling::where('is_slot', true)
            ->where('booked_by', auth()->id())
            ->findOrFail($id);

        $slot->update([
            'booked_by'    => null,
            'booking_note' => null,
            'is_anonymous' => false,
        ]);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }

    // =============================================
    //  HELPER
    // =============================================

    private function cekBentrok($pastorId, $date, $time, $duration, $excludeId = null): bool
    {
        $start = Carbon::parse($date . ' ' . $time);
        $end   = (clone $start)->addMinutes((int) $duration);

        $query = Counseling::where('is_slot', true)
            ->where('pastor_id', $pastorId)
            ->where('date', $date)
            ->where(function ($q) use ($start, $end) {
                $q->whereTime('time', '<', $end->format('H:i:s'))
                  ->whereRaw("ADDTIME(time, SEC_TO_TIME(duration * 60)) > ?", [$start->format('H:i:s')]);
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
