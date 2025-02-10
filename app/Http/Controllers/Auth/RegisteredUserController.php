<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function email(): View
    {
        return view('auth.VerifyEmail');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'mobile' => ['required', 'numeric', 'min:11', 'regex:/^0[3-9][0-9]{2}[0-9]{7}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.pattern' => "name must be alphabetical letter ",
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        if (Auth()->user()->role == 1) {
            return redirect()->route("home");
        } else {
            if (session()->has('url.intended')) {
                return redirect(session()->get('url.intended'));
            }

            return redirect()->route("index");
        }
    }
}
