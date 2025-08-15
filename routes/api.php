<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/users', \App\Http\Controllers\UserController::class)->middleware('auth:sanctum');
Route::apiResource('/categorie', \App\Http\Controllers\CategorieController::class)->middleware('auth:sanctum');
Route::apiResource('/produit', \App\Http\Controllers\ProduitController::class)->middleware('auth:sanctum');

Route::apiResource('/commande', \App\Http\Controllers\CommandeController::class)->middleware('auth:sanctum');
Route::patch('/commande/{id}/statut', [\App\Http\Controllers\CommandeController::class, 'updateStatut'])->middleware('auth:sanctum');

Route::apiResource('/commandeProduit', \App\Http\Controllers\CommandeProduitController::class)->middleware('auth:sanctum');

Route::apiResource('/livraison', \App\Http\Controllers\LivraisonController::class)->middleware('auth:sanctum');
Route::patch('/livraison/{id}/statut', [\App\Http\Controllers\LivraisonController::class, 'updateStatut'])->middleware('auth:sanctum');

Route::patch('/promotion/{id}/toggleActif', [\App\Http\Controllers\PromotionController::class, 'toggleActif'])->middleware('auth:sanctum');
Route::apiResource('/promotion', \App\Http\Controllers\PromotionController::class)->middleware('auth:sanctum');

Route::apiResource('/pack', \App\Http\Controllers\PackController::class)->middleware('auth:sanctum');
Route::apiResource('/packProduit', \App\Http\Controllers\PackProduitController::class)->middleware('auth:sanctum');
Route::apiResource('/facture', \App\Http\Controllers\FacturesController::class)->middleware('auth:sanctum');
Route::apiResource('/chatMessage', \App\Http\Controllers\ChatMessageController::class)->middleware('auth:sanctum');


Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
