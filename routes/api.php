<?php


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

Route::get('allRessourcesList', [RessourceController::class, 'allRessourcesList']);
Route::get('show-ressource/{id}', [RessourceController::class, 'showRessource']);

Route::group(['middleware' => ["auth:sanctum"]], function(){
    //routes auth
   Route::get('user-profil', [ProfilController::class, 'userProfil']);
   Route::get('logout', [UserController::class, 'logout']);

   //routes pour ressources
    Route::post('create-ressource', [RessourceController::class, 'createRessource']);
    Route::get('liste-ressource', [RessourceController::class, 'listeRessource']);
    Route::put('update-ressource/{id}', [RessourceController::class, 'updateRessource']);
    Route::delete('delete-ressource/{id}', [RessourceController::class, 'deleteRessource']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
