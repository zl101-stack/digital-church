<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRegistration;
use App\Models\Service;

class ServiceRegistrationController extends Controller
{

    public function myService()
    {
        $registrations = ServiceRegistration::with('service')
            ->where('user_id', auth()->id())
            ->get();

        $services = Service::all();

        return view('serviceregistrations.index', compact('registrations', 'services'));
    }

    public function index()
    {
        if (auth()->user()->role == 'user') {

            $registrations = ServiceRegistration::with('service')
                ->where('user_id', auth()->id())
                ->get();
        } else {

            $registrations = ServiceRegistration::with('service')->get();
        }

        $services = Service::all();

        return view('serviceregistrations.index', compact('registrations', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'position'   => 'required',
        ]);

        $exists = ServiceRegistration::where('service_id', $request->service_id)
            ->where('position', $request->position)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Posisi sudah diisi.');
        }

        ServiceRegistration::create([
            'user_id'    => auth()->id(),
            'name'       => auth()->user()->name,
            'service_id' => $request->service_id,
            'position'   => $request->position,
        ]);

        return back()->with('success', 'Berhasil daftar pelayanan.');
    }

    public function edit($id)
    {
        $registration = ServiceRegistration::findOrFail($id);

        if (
            auth()->user()->role == 'user' &&
            $registration->user_id != auth()->id()
        ) {
            abort(403);
        }

        $services = Service::all();

        return view('serviceregistrations.edit', compact('registration', 'services'));
    }

    public function update(Request $request, $id)
    {
        $registration = ServiceRegistration::findOrFail($id);

        if (
            auth()->user()->role == 'user' &&
            $registration->user_id != auth()->id()
        ) {
            abort(403);
        }

        $request->validate([
            'service_id' => 'required',
            'position'   => 'required',
        ]);

        $registration->update([
            'service_id' => $request->service_id,
            'position'   => $request->position,
        ]);

        return redirect('/service-registrations')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $registration = ServiceRegistration::findOrFail($id);

        if (
            auth()->user()->role == 'user' &&
            $registration->user_id != auth()->id()
        ) {
            abort(403);
        }

        $registration->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
