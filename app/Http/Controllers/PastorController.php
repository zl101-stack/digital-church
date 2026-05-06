<?php

namespace App\Http\Controllers;

use App\Models\Pastor;
use Illuminate\Http\Request;

class PastorController extends Controller
{
    /**
     * Tampil daftar pastor + form tambah
     */
    public function index()
    {
        $pastors = Pastor::latest()->get();
        return view('pastors.index', compact('pastors'));
    }

    /**
     * Simpan pastor baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'schedule' => 'required|string|max:255',
        ], [
            'name.required'     => 'Nama pastor wajib diisi.',
            'schedule.required' => 'Jadwal pastor wajib diisi.',
        ]);

        Pastor::create([
            'name'     => $request->name,
            'schedule' => $request->schedule,
        ]);

        return redirect()->route('pastors.index')
            ->with('success', 'Pastor berhasil ditambahkan.');
    }

    /**
     * Form edit pastor
     */
    public function edit(Pastor $pastor)
    {
        return view('pastors.edit', compact('pastor'));
    }

    /**
     * Update data pastor
     */
    public function update(Request $request, Pastor $pastor)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'schedule' => 'required|string|max:255',
        ], [
            'name.required'     => 'Nama pastor wajib diisi.',
            'schedule.required' => 'Jadwal pastor wajib diisi.',
        ]);

        $pastor->update([
            'name'     => $request->name,
            'schedule' => $request->schedule,
        ]);

        return redirect()->route('pastors.index')
            ->with('success', 'Data pastor berhasil diperbarui.');
    }

    /**
     * Hapus pastor
     */
    public function destroy(Pastor $pastor)
    {
        $pastor->delete();

        return redirect()->route('pastors.index')
            ->with('success', 'Pastor berhasil dihapus.');
    }
}
