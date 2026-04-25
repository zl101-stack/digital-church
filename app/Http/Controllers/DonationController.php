<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donations = Donation::with('user')->get();
        $total = Donation::sum('amount');

        return view('donations.index', compact('donations', 'total'));
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
            'user_id' => $isAnonymous ? null : auth()->id(), // ✅ FIX
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
            'amount' => 'required|numeric|min:1000',
            'note' => 'nullable|max:255',
        ]);

        $isAnonymous = $request->has('is_anonymous');

        Donation::create([
            'user_id' => $isAnonymous ? null : auth()->id(), // ✅ FIX
            'amount' => $request->amount,
            'note' => $request->note,
            'date' => now(),
            'is_anonymous' => $isAnonymous,
        ]);

        return redirect()->back()->with('success', 'Terima kasih, donasi berhasil dikirim.');
    }
}