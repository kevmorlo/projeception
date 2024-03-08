<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\ProductStatusEnum;
use App\Models\Utilisateur;

class UtilisateurController extends Controller
{
    public function index(int $id) {
        $utilisateur = Utilisateur::find($id);
        return view('utilisateur.show', ['utilisateur'=>$utilisateur]);
    }

    public function showAll() {
        $utilisateur = Utilisateur::all();
        return view('utilisateur.show-all', ['utilisateur'=>$utilisateur]);
    }
}
