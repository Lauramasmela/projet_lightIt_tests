<?php

namespace App\Http\Controllers;


use App\Models\Categorie;
use App\Models\Favorit;
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

        $ressource->categories()->attach($request->listeCategories);

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
    public function listeRessourcesByUser()
    {
        // l'utilisateur qui se connecte peut voir sa liste.
        $user_id = auth()->user()->id;
        $ressources = Ressource::where('user_id', $user_id)->get();

        return response([
            "status" => 1,
            "msg" => "Liste de toutes les ressources de " . auth()->user()->pseudo,
            "data" => $ressources
        ]);
    }

    public function updateRessource(Request $request)
    {
        $user_id = auth()->user()->id;

        if (Ressource::where(['user_id' => $user_id, 'id' => $request->id])->exists()) {
            // S'il existe
            $ressource = Ressource::find($request->id);

            $ressource->titre = $request->titre;
            // $ressource->titre = isset($request->titre) ? $request->titre : $ressource->titre;
            $ressource->contenu = $request->contenu;
            // $ressource->titre = isset($request->titre) ? $request->titre : $ressource->titre;
            $ressource->save();

            $ressource->categories()->sync($request->listeCategories);

            return response([
                "status" => 1,
                "msg" => "La ressource avec l'id " . $request->id . " a été modifiée avec succès !",
            ]);

        } else {
            return response([
                "status" => 0,
                "msg" => "La ressource n'existe pas",
            ], 404);
        }
    }

    /*public function categoriseRessource($id){

        // appel du tableau des categories choisies
        $categorie = Categorie::find([2]);
        // inserer dans find les categories cochées à attacher,
        // normalement c'est un tableau post avec des checkboxes

        $ressource = Ressource::find($id);
        $ressource->categories()->attach($categorie);

        return response([
            "status" => 1,
            "msg" => "la ressource a été categorisée avec succès !",
        ]);
    }*/
    /*public function unCategoriseRessource($id){
        $categorie = Categorie::find(2);
        //inserer dans find les categories cochées à detacher

        $ressource = Ressource::find($id);

        $ressource->categories()->detach($categorie);

        return response([
            "status" => 1,
            "msg" => "la categorie a été détachée avec succès !",
        ]);
    }*/


    public function addToFavorits($id){
        $user_id = auth()->user()->id;
          $ressource = Ressource::findOrFail([$id]);

            if(Favorit::where(['user_id' => $user_id, 'ressource_id' =>  $id])->exists()){
                return response([
                    "status" => 0,
                    "msg" => "cette ressource existe déjà dans votre liste de favorits !",
                ]);

            }else{

                auth()->user()->favorits()->attach($ressource);
                return response([
                    "status" => 1,
                    "msg" => "la ressource vient d'être ajoutée aux Favoris !",
                ]);
            }
    }

    public function removeFromFavorits($id){
        $user_id = auth()->user()->id;
        $ressource = Ressource::findOrFail([$id]);
        if(Favorit::where(['user_id' => $user_id, 'ressource_id' =>  $id])->exists()){
            auth()->user()->favorits()->detach($ressource);
            return response([
                "status" => 1,
                "msg" => "Cette ressource a été retirée des Favoris correctement !",
            ]);

        }
    }

    /*********************** Pour modérateur ********************************/

    public function validateRessource(Request $request, $id){
        $user_id = auth()->user()->id;

        if (Ressource::where(['user_id' => $user_id, 'id' => $id])->exists()) {

            $ressource = Ressource::find($id);

            $ressource->publiee = isset($request->publiee) ? $request->publiee : $ressource->publiee;

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

    /************************** Pour l'admin *****************************/

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
