<?php


use App\Http\Controllers\CategorieController;
use App\Http\Controllers\RoleController;
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

Route::get('all-ressources-list', [RessourceController::class, 'allRessourcesList'])->name('all_ressources_list');
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
    Route::get('user-ressources-list', [RessourceController::class, 'listeRessourcesByUser']);
    //Route::put('update-ressource/{id}', [RessourceController::class, 'updateRessource']);
    Route::put('update-ressource', [RessourceController::class, 'updateRessource']);
    Route::post('show-ressource/{id}', [RessourceController::class, 'addToFavorits']);
    Route::delete('show-ressource/{id}', [RessourceController::class, 'removeFromFavorits']);
        //admin
    Route::delete('delete-ressource/{id}', [RessourceController::class, 'deleteRessource']);

        //moderateur
    Route::put('ressource-validate/{id}', [RessourceController::class, 'validateRessource']);

    /*** routes pour categories ***/
        //admin
    Route::post('admin/create-category', [CategorieController::class, 'createCategory']);
    Route::get('admin/category-list', [CategorieController::class, 'categoryList']);
    Route::put('admin/update-category/{id}', [CategorieController::class, 'updateCategory']);
    Route::delete('admin/delete-category/{id}', [CategorieController::class, 'deleteCategory']);

    /*** routes pour categories ***/
        //super-admin
    Route::post('super-admin/create-role', [RoleController::class, 'createRole']);
    Route::post('super-admin/create-user', [UserController::class, 'createUserWithRole']);


});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
