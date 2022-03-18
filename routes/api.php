<?php


use App\Http\Controllers\CategorieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RessourceController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::get('allRessourcesList', [RessourceController::class, 'allRessourcesList'])->name('all_ressources_list');
Route::get('show-ressource/{id}', [RessourceController::class, 'showRessource']);

Route::group(['middleware' => ["auth:sanctum"]], function(){
    //routes auth
   Route::get('user-profil', [ProfilController::class, 'userProfil']);
   Route::get('logout', [UserController::class, 'logout']);

    /*** routes pour Users ***/

    Route::get('show-user/{id}', [UserController::class, 'showUser']);
    Route::put('update-profile/{id}', [UserController::class, 'updateUser']);
        //route admin
    Route::put('activation-user/{id}', [UserController::class, 'accountActivation']);

    /*** routes pour ressources ***/

    Route::post('create-ressource', [RessourceController::class, 'createRessource']);
    Route::get('liste-ressource', [RessourceController::class, 'listeRessourcesByUser']);
    Route::put('update-ressource/{id}', [RessourceController::class, 'updateRessource']);
    Route::post('show-ressource/{id}', [RessourceController::class, 'addToFavorits']);
    Route::delete('show-ressource/{id}', [RessourceController::class, 'removeFromFavorits']);

        //admin
    Route::delete('delete-ressource/{id}', [RessourceController::class, 'deleteRessource']);
    Route::post('categoriser-ressource/{id}', [RessourceController::class, 'categoriseRessource']);
    Route::delete('decategoriser-ressource/{id}', [RessourceController::class, 'unCategoriseRessource']);
        //moderateur
    Route::put('ressource-validate/{id}', [RessourceController::class, 'validateRessource']);


    /*** routes pour categories ***/
        //admin
    Route::post('create-categorie', [CategorieController::class, 'createCategory']);
    Route::get('liste-categorie', [CategorieController::class, 'categoryList']);
    Route::put('update-categorie/{id}', [CategorieController::class, 'updateCategory']);
    Route::delete('delete-categorie/{id}', [CategorieController::class, 'deleteCategory']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
