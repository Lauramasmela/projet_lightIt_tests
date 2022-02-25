<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pseudo',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // relation one to one
    public function profils(){
        return $this->hasOne('App\Models\Profil');
    }

    // relation one to many
    public function ressources(){
        return $this->hasMany('App\Models\Ressource');
    }

    public function commentaires(){
        return $this->hasMany('App\Models\Commentaire');
    }

    // relation many to many
    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }

    public function favorits(){
        return $this->belongsToMany('App\Models\Ressource', 'favorits');
    }

}
