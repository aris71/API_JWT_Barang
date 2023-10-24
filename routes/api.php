<?php

use App\Http\Controllers\ArticleCommentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);


});

Route::get('coba',function(){
    return'coba';
});

Route::get('findAll', [BarangController::class, 'findAll']);
Route::get('findByID/{id}', [BarangController::class, 'findByID']);
Route::post('addBarang',[BarangController::class,'addBarang']);
Route::put('editBarang/{id}',[BarangController::class,'editBarang']);
Route::delete('deleteBarang/{id}',[BarangController::class,'deleteBarang']);


