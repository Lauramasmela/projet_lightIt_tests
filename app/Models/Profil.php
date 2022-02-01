<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    //relation one to one
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
