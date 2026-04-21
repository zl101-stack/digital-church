<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceRegistration;

class ServiceController extends Controller
{

    public function registrations()
    {
        $registrations = ServiceRegistration::with(['user', 'service'])->get();

        return view('serviceregistrations.index', compact('registrations'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Service::create($request->all());
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $service->update([
            'title' => $request->title,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect('/services')->with('success', 'Jadwal berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return back();
    }

    public function register($id)
    {
        ServiceRegistration::create([
            'user_id' => auth()->user()->id,
            'service_id' => $id,
        ]);

        return back();
    }
}
