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

    public function updateUser(Request $request, $id){

        if(User::where(['id' => $id])->exists() && (auth()->user()->id == $id)){

            $user = User::find([$id]);
            $user->prenom = isset($request->prenom) ? $request->prenom : $user->prenom;
            $user->nom = isset($request->nom) ? $request->nom : $user->nom;
            $user->adresse = isset($request->adresse) ? $request->adresse : $user->adresse;
            $user->ville = isset($request->ville) ? $request->ville : $user->ville;
            $user->codePostal = isset($request->codePostal) ? $request->codePostal : $user->codePostal;

            $user->save();

            return response([
                "status" => 1,
                "msg" => "Votre information a été modifiée correctement !",
            ]);

        }

    }


    /************************ Réservé à l'admin *****************************/

    public function showUser($id){
        $user = User::where('id', $id)->first();

        return response([
            "status" => 1,
            "msg" => "Info user",
            "data" => $user
        ]);
    }
    public function accountActivation(Request $request, $id){
        if (auth()->user()->isAdministrator()){
            if(User::where(['id' => $id])->exists()){
                $user = User::where(['id' => $id])->first();
                $user->actif = isset($request->actif) ? $request->actif : $user->actif;
                $user->save();

                return response([
                    "status" => 1,
                    "msg" => "Le statut de l'utilisateur a été modifié correctement !",
                ]);
            }else{
                return response([
                    "status" => 0,
                    "msg" => "Cet utilisateur n'existe pas",
                ]);
            }
        }else{
            return response([
                "status" => 0,
                "msg" => "Vous n'avez pas le droit d'exécuter cette action",
            ]);
        }

    }

    /*************************** Super-admin **************************/

    public function createUserWithRole(Request $request){

        if(auth()->user()->isSuperadministrator()){
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

            $user->roles()->attach($request->listeRoles);


            return response()->json([
                "status" => 1,
                "msg" => "L'enregistrement s'est déroulé avec succès",
            ]);

        }else{
            return response()->json([
                "status" => 0,
                "msg" => "Cette utilisateur n'a pas le droit de créer des nouveaux administrateurs",
            ]);
        }

    }
}
