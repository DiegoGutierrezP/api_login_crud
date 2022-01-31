<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);

Route::group(['middleware'=> ['auth:sanctum']],function(){
    Route::get('user-profile',[UserController::class,'userProfile']);
    Route::get('logout',[UserController::class,'logout']);
    //Rutas para el post
    Route::post('create-post',[PostController::class,'create']);
    Route::get('list-post',[PostController::class,'list']);
    Route::get('show-post/{id}',[PostController::class,'show']);
    Route::put('update-post/{id}',[PostController::class,'update']);
    Route::delete('delete-post/{id}',[PostController::class,'delete']);
});
