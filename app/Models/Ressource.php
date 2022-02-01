<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    // relation one to many
    public function users(){
        return $this->belongsTo('App\Models\User');
    }

    public function commentaires(){
        return $this->hasMany('App\Models\Commentaire');
    }
}
