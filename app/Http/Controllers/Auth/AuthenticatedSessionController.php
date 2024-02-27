<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Check the user's role and redirect accordingly
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('restaurant_owner')) {
                return redirect()->route('restaurant_owner.dashboard');
            } elseif ($user->hasRole('operator')) {
                return redirect()->route('operator.dashboard');
            } else {
                // If the user has no defined role, redirect to the default dashboard
                return redirect()->route('user.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    } 

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function redirectToGoogle()
    {
        
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
         
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google authentication failed.');
        }
       
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            Auth::login($existingUser);
           
        } else {
            $newUser = new User();
            $newUser->name = $googleUser->getName();
            $newUser->email = $googleUser->getEmail();
            $newUser->password = bcrypt(Str::random(16));
            $newUser->save();

            Auth::login($newUser);
            
        }
       
        return redirect('/dashboard')->with('success', 'Google authentication successful.');
    }

}
