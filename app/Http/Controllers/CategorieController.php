<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /****************** Réservé à l'admin ************************/

    public function createCategory(Request $request){
        $request->validate([
           'nom' => 'required'
        ]);

        $categorie = new Categorie();
        $categorie->nom = $request->nom;
        $categorie->save();

        return response([
           "status" => 1,
           "msg" => "La categorie vient d'être créée avec succès !"
        ]);
    }


    public function updateCategory(Request $request, $id){

        if(Categorie::where(['id' => $id])->exists()){

            $categorie = Categorie::find($id);
            $categorie->nom = $request->nom;
            $categorie->save();

            return response([
               "status" => 1,
               "msg" => "La catégorie a été modifiée avec succès !",
            ]);
        }else{
            return response([
                "status" => 0,
                "msg" => "Cette catégorie n'existe pas",
            ], 404);
        }

    }

    public function deleteCategory($id){
        if(Categorie::where(['id' => $id])->exists()){

            $categorie = Categorie::where(['id' => $id])->first();
            $categorie->delete();

            return response([
                "status" => 1,
                "msg" => "La catégorie a été supprimée avec succès !",
            ]);
        }else{
            return response([
                "status" => 0,
                "msg" => "Cette catégorie n'existe pas",
            ], 404);
        }

    }

    /****************** Pour citoyen connecté ************************/

    public function categoryList(){
        $categories = Categorie::all();

        return response([
            "status" => 1,
            "msg" => "Liste de toutes les ressources",
            "data" => $categories,
        ]);
    }
    
}
