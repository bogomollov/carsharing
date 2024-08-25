<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Arendator;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|lowercase|email|max:255|unique:'.Arendator::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'status' => 'required|string',
            'passport_series' => 'required|string',
            'passport_number' => 'required|string|unique',
            'driverlicense_series' => 'required|string',
            'driverlicense_number' => 'required|string|unique',
            'driverlicense_date' => 'required|string',
            'phone' => 'required|string|unique',
        ]);

        $user = Arendator::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'status' => $request->status,
            'passport_series' => $request->passport_series,
            'passport_number' => $request->passport_number,
            'driverlicense_series' => $request->driverlicense_series,
            'driverlicense_number' => $request->driverlicense_number,
            'driverlicense_date' => $request->driverlicense_date,
            'phone' => $request->phone,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
