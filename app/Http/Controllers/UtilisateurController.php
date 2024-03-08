<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\ProductStatusEnum;
use App\Models\Utilisateur;

/**
 * Gère les actions liées aux utilisateurs
 * @see Utilisateur
 */
class UtilisateurController extends Controller
{
    /**
     * Affiche un utilisateur
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function index(int $id) {
        $utilisateur = Utilisateur::find($id);
        return view('utilisateur.show', ['utilisateur'=>$utilisateur]);
    }

    /**
     * Affiche tous les utilisateurs
     * @return \Illuminate\View\View
     */
    public function showAll() {
        $utilisateur = Utilisateur::all();
        return view('utilisateur.show-all', ['utilisateur'=>$utilisateur]);
    }
}
