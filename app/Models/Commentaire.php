<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    // relation one to many
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function ressource(){
        return $this->belongsTo('App\Models\Ressource');
    }
}
