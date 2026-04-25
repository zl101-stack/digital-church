<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceRegistration;

class ServiceController extends Controller
{
    /* ADMIN + SUPERADMIN */
    public function index()
    {
        $services = Service::latest()->get();
        return view('services.index', compact('services'));
    }

    /* USER READ ONLY */
    public function userIndex()
    {
        $services = Service::latest()->get();
        return view('user.services', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required',
            'description' => 'required'
        ]);

        Service::create([
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required',
            'description' => 'required'
        ]);

        $service->update([
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        return redirect('/services')->with('success', 'Jadwal berhasil diupdate');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return back()->with('success', 'Jadwal berhasil dihapus');
    }

    /* USER JOIN PELAYANAN */
    public function register($id)
    {
        $cek = ServiceRegistration::where('user_id', auth()->id())
            ->where('service_id', $id)
            ->first();

        if ($cek) {
            return back()->with('error', 'Kamu sudah daftar pelayanan ini');
        }

        ServiceRegistration::create([
            'user_id' => auth()->id(),
            'service_id' => $id,
        ]);

        return back()->with('success', 'Berhasil daftar pelayanan');
    }

    /* ADMIN LIHAT PENDAFTAR */
    public function registrations()
    {
        $registrations = ServiceRegistration::with(['user', 'service'])->latest()->get();

        return view('serviceregistrations.index', compact('registrations'));
    }
}