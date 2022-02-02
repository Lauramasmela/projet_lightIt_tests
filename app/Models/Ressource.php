<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'titre',
        'contenu',
    ];

    // relation one to many
    public function users(){
        return $this->belongsTo('App\Models\User');
    }

    public function commentaires(){
        return $this->hasMany('App\Models\Commentaire');
    }

    //relation many to many
    public function categories(){
        return $this->belongsToMany('App\Models\Categorie');
    }

    public function typeRessources(){
        return $this->belongsToMany('App\Models\TypeRessource');
    }
}
