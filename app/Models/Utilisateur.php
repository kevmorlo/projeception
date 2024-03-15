<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Utilisateur extends Authenticatable
{
    
    /**
     * Les attributs étant assignables à tous.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pseudonyme',
        'email',
        'mdp',
    ];
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;
    
    /**
     * Les attributs devant être cachés.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mdp',
        'remember_token',
    ];

    /**
     * Les attributs pouvant être affichés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verifie_a' => 'datetime',
        'mdp' => 'hashed',
    ];
}
