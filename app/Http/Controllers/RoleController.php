<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function createRole(Request $request){
        $request->validate([
            'nom' => 'required'
        ]);

        $role = new Role();
        $role->nom = $request->nom;
        $role->save();

        return response()->json([
           "status" => 1,
           "msg" => "Un nouveau rôle vient d'être ajouté avec succès "
        ]);
    }

}
