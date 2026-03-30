<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
            return redirect()->route('depenses.index');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Déterminer le guard selon le rôle de l'utilisateur
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email ou mot de passe incorrect.',
            ])->onlyInput('email');
        }

        $guard = $user->role === 'admin' ? 'admin' : 'web';

        if (Auth::guard($guard)->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('depenses.index'));
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $guard = $request->input('guard', 'web');

        Auth::guard($guard)->logout();

        // Invalider la session seulement si personne n'est plus connecté
        if (!Auth::guard('web')->check() && !Auth::guard('admin')->check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login');
    }
}
