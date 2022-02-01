<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressouce extends Model
{
    use HasFactory;

    // relation one to many
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
