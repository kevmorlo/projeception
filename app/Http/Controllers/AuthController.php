<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Affiche la page de connexion
     * @return \Illuminate\View\View
     */
    public function login() {
        return view('auth.login');
    }

    public function loginPost(LoginRequest $request) {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('accueil'));
        } else {
            return back()->withErrors([
                'pseudonyme' => 'Ce pseudonyme n\'existe pas',
                'mdp' => 'Le mot de passe est incorrect'
            ])->onlyInput('pseudonyme');
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('accueil'));
    }
}
