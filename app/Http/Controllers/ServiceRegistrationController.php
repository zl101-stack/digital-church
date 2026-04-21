<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRegistration;
use App\Models\Service;

class ServiceRegistrationController extends Controller
{
    public function index()
    {
        $registrations = ServiceRegistration::with('service')->get();
        $services = Service::all();

        return view('serviceregistrations.index', compact('registrations', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'service_id' => 'required',
            'position' => 'required',
        ]);

        // cek apakah posisi sudah dipakai di service yang sama
        $exists = ServiceRegistration::where('service_id', $request->service_id)
            ->where('position', $request->position)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Posisi ini sudah terisi untuk jadwal tersebut');
        }


        ServiceRegistration::create([
            'name' => $request->name,
            'service_id' => $request->service_id,
            'position' => $request->position,
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $registration = ServiceRegistration::findOrFail($id);
        $services = Service::all();

        return view('serviceregistrations.edit', compact('registration', 'services'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'service_id' => 'required',
            'position' => 'required',
        ]);

        $exists = ServiceRegistration::where('service_id', $request->service_id)
            ->where('position', $request->position)
            ->where('id', '!=', $id) 
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'position' => 'Posisi ini sudah diambil di jadwal tersebut!'
            ])->withInput();
        }
        $registration = ServiceRegistration::findOrFail($id);

        $registration->update([
            'name' => $request->name,
            'service_id' => $request->service_id,
            'position' => $request->position,
        ]);

        return redirect('/service-registrations')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        ServiceRegistration::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
