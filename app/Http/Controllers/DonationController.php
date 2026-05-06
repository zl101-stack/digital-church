<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Exports\DonationsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Donation::with('user')->orderBy('date', 'desc');

        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $donations = $query->get();
        $total     = $donations->sum('amount');

        return view('donations.index', compact('donations', 'total', 'startDate', 'endDate'));
    }

    /**
     * Export donasi ke Excel (superadmin only)
     */
    public function export(Request $request)
    {
        abort_unless(auth()->user()->role === 'superadmin', 403);

        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        $filename = 'donasi';
        if ($startDate || $endDate) {
            $filename .= '_' . ($startDate ?? 'awal') . '_sd_' . ($endDate ?? 'akhir');
        }
        $filename .= '.xlsx';

        return Excel::download(new DonationsExport($startDate, $endDate), $filename);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // tidak dipakai (kita pakai form di index)
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isAnonymous = $request->has('is_anonymous');

        Donation::create([
            'user_id' => $isAnonymous ? null : auth()->id(), 
            'amount' => $request->amount,
            'note' => $request->note,
            'date' => now(),
            'is_anonymous' => $isAnonymous,
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        return view('donations.show', compact('donation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        return view('donations.edit', compact('donation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        $donation->update([
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        return redirect('/donations')->with('success', 'Donasi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->back();
    }

    /**
     * Form user (frontend user)
     */
    public function userForm()
    {
        return view('user.donation');
    }

    /**
     * Store dari user
     */
    public function userStore(Request $request)
    {
        $request->validate([
            'amount'         => 'required|numeric|min:1000',
            'note'           => 'nullable|max:255',
            'payment_method' => 'required|in:manual,qris',
        ]);

        $isAnonymous = $request->has('is_anonymous');

        Donation::create([
            'user_id'        => $isAnonymous ? null : auth()->id(),
            'amount'         => $request->amount,
            'note'           => $request->note,
            'date'           => now(),
            'is_anonymous'   => $isAnonymous,
            'payment_method' => $request->payment_method,
        ]);

        $msg = $request->payment_method === 'qris'
            ? 'Terima kasih! Donasi via QRIS berhasil dicatat. Tuhan memberkati 🙏'
            : 'Terima kasih, donasi berhasil dikirim. Tuhan memberkati 🙏';

        return redirect()->back()->with('success', $msg);
    }
}