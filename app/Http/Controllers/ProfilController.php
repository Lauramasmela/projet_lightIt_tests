<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function userProfil()
    {
        return response()->json([
            "status" => 0,
            "msg" => "Info de profil de l'utilisateur connecté",
            "data" => auth()->user()
        ]);

    }
}
