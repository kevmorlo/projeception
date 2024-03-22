<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\ProductStatusEnum;
use App\Models\User;

/**
 * Gère les actions liées aux users
 * @see User
 */
class UserController extends Controller
{
    /**
     * Affiche un user
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function index(int $id) {
        $user = User::find($id);
        return view('user.show', ['user'=>$user]);
    }

    /**
     * Affiche tous les users
     * @return \Illuminate\View\View
     */
    public function showAll() {
        $user = User::all();
        return view('user.show-all', ['user'=>$user]);
    }
}
