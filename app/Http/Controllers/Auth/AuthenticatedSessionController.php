<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
    /**
 * Gérer une demande d'authentification entrante.
 */
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    // Vérifier si l'utilisateur est authentifié et a le rôle de leader (super admin) ou membre
    if (Auth::check()) {
        if (Auth::user()->role === 'leader') {
            return redirect('/dashboard'); // Rediriger vers le dashboard du leader
        } elseif (Auth::user()->role === 'member') {
            return redirect('/home'); // Rediriger vers le dashboard du membre
        }
    }

    // Déconnexion de l'utilisateur en cas de mauvaise information d'identification
    Auth::logout();

    // Redirection vers une page avec un message d'erreur
    return redirect()->route('login')->withErrors(['login' => 'Vos informations de connexion sont incorrectes.']);
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
