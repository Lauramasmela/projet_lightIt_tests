<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    // relation one to many
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function commentaire(){
        return $this->hasMany('App\Models\Commentaire');
    }
}
