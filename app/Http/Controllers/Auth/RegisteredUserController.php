<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Employe;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $entreprises = Entreprise::orderBy('nom')->get();

        return view('auth.register', compact('entreprises'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'entreprise_id' => ['required', 'exists:entreprises,id'],
            'nom' => ['required', 'string', 'max:255'],
            'ville_residence' => ['required', 'string', 'max:255'],
            'role' => ['required', Rule::in(['conducteur', 'passager', 'les_deux'])],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:employes,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $employe = Employe::create([
            'nom' => $validated['nom'],
            'entreprise_id' => $validated['entreprise_id'],
            'ville_residence' => $validated['ville_residence'],
            'role' => $validated['role'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($employe));

        Auth::login($employe);

        return redirect(route('dashboard', absolute: false));
    }
}
