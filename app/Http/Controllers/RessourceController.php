<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Ressource;


class RessourceController extends Controller
{
    public function createRessource(Request $request)
    {

        $request->validate([
            'titre' => 'required|max:250',
            'contenu' => 'required'
        ]);

        // pour savoir qui a cree la ressource
        $user_id = auth()->user()->id;
        $ressource = new Ressource();

        $ressource->user_id = $user_id;
        $ressource->titre = $request->titre;
        $ressource->contenu = $request->contenu;

        $ressource->save();







        return response([
            "status" => 1,
            "msg" => "La ressource vient d'être créée avec succès !",
        ]);
    }


    public function showRessource($id)
    {
        $ressource = Ressource::where('id', $id)->first();

        return response([
            "status" => 1,
            "msg" => "Détail de la ressource",
            "data" => $ressource
        ]);

    }

    public function allRessourcesList(){

        $ressources = Ressource::all();

        return response([
            "status" => 1,
            "msg" => "Liste de toutes les ressources",
            "data" => $ressources
        ]);
    }
    public function listeRessource()
    {
        $user_id = auth()->user()->id;
        $ressources = Ressource::where('user_id', $user_id)->get();

        return response([
            "status" => 1,
            "msg" => "Liste de toutes les ressources de " . auth()->user()->pseudo,
            "data" => $ressources
        ]);
    }

    public function updateRessource(Request $request, $id)
    {
        $user_id = auth()->user()->id;

        if (Ressource::where(['user_id' => $user_id, 'id' => $id])->exists()) {
            // S'il existe
            $ressource = Ressource::find($id);

            $ressource->titre = $request->titre;
            // $ressource->titre = isset($request->titre) ? $request->titre : $ressource->titre;
            $ressource->contenu = $request->contenu;
            // $ressource->titre = isset($request->titre) ? $request->titre : $ressource->titre;
            $ressource->save();

            return response([
                "status" => 1,
                "msg" => "La ressource avec l'id " . $id . " a été modifiée avec succès !",
            ]);

        } else {
            return response([
                "status" => 0,
                "msg" => "La ressource n'existe pas",
            ], 404);
        }
    }

    /*********************** validation de la ressource (modérateur) ********************************/
    public function validateRessource(Request $request, $id){
        $user_id = auth()->user()->id;

        if (Ressource::where(['user_id' => $user_id, 'id' => $id])->exists()) {

            $ressource = Ressource::find($id);

            $ressource->publiee = isset($request->publiee) ?
                $request->publiee : $ressource->publiee;

            $ressource->save();

            return response([
                "status" => 1,
                "msg" => "La ressource avec l'id " . $id . " a été validée avec succès !",
            ]);

        } else {
            return response([
                "status" => 0,
                "msg" => "La ressource n'existe pas",
            ], 404);
        }
    }

    /*******************************************************/

    public function deleteRessource($id){
        $user_id = auth()->user()->id;
        if (Ressource::where(['id'=>$id, "user_id"=>$user_id])->exists()){
            $ressource = Ressource::where(['id'=>$id, "user_id"=>$user_id])->first();
            $ressource->delete();

            return response([
                "status" => 1,
                "msg" => "La resource a été supprimée correctement !",
            ]);
        }else{
            return response([
                "status" => 0,
                "msg" => "Cette ressouce n'existe pas",
            ], 404);
        }
    }


}
