<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display register page
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Register normal user
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        $user = User::create([
            'name' => strip_tags($request->name),
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('user.home');
    }

    /**
     * Display admin register page
     */
    public function createAdmin(): View
    {
        return view('auth.register');
    }

    /**
     * Register admin
     */
    public function storeAdmin(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        User::create([
            'name' => strip_tags($request->name),
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('login')
            ->with('success', 'Admin berhasil dibuat.');
    }

    /**
     * Display superadmin register page
     */
    public function createSuperAdmin(): View
    {
        return view('auth.register');
    }

    /**
     * Register superadmin
     */
    public function storeSuperAdmin(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'secret_key' => ['required', 'string'],
        ]);

        /**
         * Simpan di .env:
         * SUPERADMIN_SECRET=church123
         */

        if ($request->secret_key !== env('SUPERADMIN_SECRET')) {
            return back()
                ->withInput()
                ->withErrors([
                    'secret_key' => 'Secret key salah.',
                ]);
        }

        User::create([
            'name' => strip_tags($request->name),
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role' => 'superadmin',
        ]);

        return redirect()->route('login')
            ->with('success', 'Superadmin berhasil dibuat.');
    }
}