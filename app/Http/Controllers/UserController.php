<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'pseudo' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = new User();
        $user->pseudo = $request->pseudo;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            "status" => 1,
            "msg" => "L'enregistrement s'est déroulé avec succès",
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where("email", "=", $request->email)->first();
        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {
                // creation du token
                $token = $user->createToken("auth_token")->plainTextToken;

                // si ok
                return response()->json([
                   "status" => 1,
                   "msg" => "Utilisateur connecté !",
                   "access_token" => $token,
                ]);


            } else {
                return response()->json([
                    "status" => 0,
                    "msg" => "Le mot de passe est incorrecte",
                ], 404);
            }
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "L'utilisateur n'est pas enregistré",
            ], 404);
        }
    }

    public function logout(){
        //supprimer le token
        auth()->user()->tokens()->delete();

        // msg de confirmation
        return response()->json([
            "status" => 1,
            "msg" => "Utilisateur déconnecté !",
        ] );
    }

    /************************Réservé à l'admin *****************************/

    public function desactivateAccount(Request $request, $id){

        if(User::where(['id' => $id])->exists()){
            $user = User::find([$id]);
            $user->actif = isset($request->actif) ? $request->actif : $user->actif;
            $user->save();
            return response([
                "status" => 1,
                "msg" => "L'utilisateur ".$user->prenom." ".$user->nom." vient d'être désactivé correctement !",
            ]);
        }else{
            return response([
                "status" => 0,
                "msg" => "Cet utilisateur n'existe pas",
            ]);
        }

    }



}
