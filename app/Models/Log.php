<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 
        'project_id', 
        'team_id', 
        'user_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
