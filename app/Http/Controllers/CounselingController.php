<?php

namespace App\Http\Controllers;

use App\Models\Counseling;
use App\Models\Pastor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CounselingController extends Controller
{
    // =========================================
    //  TAMPIL DATA (ADMIN)
    // =========================================
    public function index()
    {
        $counselings = Counseling::with('pastor', 'user')->latest()->get();
        $pastors = Pastor::all();

        return view('counselings.index', compact('counselings', 'pastors'));
    }

    // =========================================
    //  VIEW USER
    // =========================================
    public function userView()
    {
        $counselings = Counseling::with('pastor', 'user')->latest()->get();
        $pastors = Pastor::all();

        return view('user.counseling', compact('counselings', 'pastors'));
    }

    // =========================================
    //  EDIT
    // =========================================
    public function edit($id)
    {
        $counseling = Counseling::findOrFail($id);
        $pastors = Pastor::all();

        return view('counselings.edit', compact('counseling', 'pastors'));
    }

    // =========================================
    //  UPDATE
    // =========================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'pastor_id' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer|in:30,60',
            'note' => 'nullable|string',
        ]);

        // 🔥 FIX FORMAT JAM (TANPA UBAH LOGIKA)
        $time = date('H:i:s', strtotime($request->time));

        $start = Carbon::parse($request->date . ' ' . $time);
        $end = (clone $start)->addMinutes((int) $request->duration);

        $exists = Counseling::where('pastor_id', $request->pastor_id)
            ->where('date', $request->date)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->whereTime('time', '<', $end)
                      ->whereRaw("ADDTIME(time, SEC_TO_TIME(duration * 60)) > ?", [$start->format('H:i:s')]);
                });
            })
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['time' => 'Jam konseling bentrok dengan jadwal lain'])
                ->withInput();
        }

        $counseling = Counseling::findOrFail($id);

        $counseling->update([
            'pastor_id' => $request->pastor_id,
            'date' => $request->date,
            'time' => $time,
            'duration' => (int) $request->duration,
            'is_anonymous' => $request->has('is_anonymous'),
            'note' => $request->note,
        ]);

        return redirect('/counseling')->with('success', 'Data berhasil diupdate');
    }

    // =========================================
    //  DELETE
    // =========================================
    public function destroy($id)
    {
        $counseling = Counseling::findOrFail($id);
        $counseling->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    // =========================================
    //  STORE
    // =========================================
    public function store(Request $request)
    {
        $request->validate([
            'pastor_id' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|in:30,60',
            'note' => 'nullable|string',
        ]);

        // 🔥 FIX FORMAT JAM (TANPA UBAH LOGIKA)
        $time = date('H:i:s', strtotime($request->time));

        $start = Carbon::parse($request->date . ' ' . $time);
        $end = (clone $start)->addMinutes((int) $request->duration);

        $exists = Counseling::where('pastor_id', $request->pastor_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->whereTime('time', '<', $end)
                      ->whereRaw("ADDTIME(time, SEC_TO_TIME(duration * 60)) > ?", [$start->format('H:i:s')]);
                });
            })
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['time' => 'Jam konseling bentrok dengan jadwal lain'])
                ->withInput();
        }

        Counseling::create([
            'user_id' => auth()->user()->id,
            'pastor_id' => $request->pastor_id,
            'date' => $request->date,
            'time' => $time,
            'duration' => $request->duration,
            'is_anonymous' => $request->has('is_anonymous'),
            'note' => $request->note,
        ]);

        return back()->with('success', 'Booking berhasil ditambahkan');
    }
}