<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GambarController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;


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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    //kategori
    Route::post('kategori',[KategoriController::class,'store']);
    Route::get('kategori/{id}',[KategoriController::class,'show']);
    Route::match(['put', 'post'], 'kategori-update/{id}', [KategoriController::class, 'update']);
    Route::delete('kategori-delete/{id}', [KategoriController::class,'destroy']);        
    
    //gambar
    Route::post('gambar',[GambarController::class,'store']);
    Route::match(['put', 'post'], 'gambar-update/{id}', [GambarController::class, 'update']);
    Route::delete('gambar-delete/{id}', [GambarController::class,'destroy']);    
    
     //dokter
     Route::post('dokter',[DokterController::class,'store']);
     Route::get('dokter/{id}',[DokterController::class,'show']);
     Route::match(['put', 'post'], 'dokter-update/{id}', [DokterController::class, 'update']);
     Route::delete('dokter-delete/{id}', [DokterController::class,'destroy']); 

      //supplier
      Route::post('supplier',[SupplierController::class,'store']);
      Route::get('supplier/{id}',[SupplierController::class,'show']);
      Route::match(['put', 'post'], 'supplier-update/{id}', [SupplierController::class, 'update']);
      Route::delete('supplier-delete/{id}', [SupplierController::class,'destroy']); 

    //like
    Route::post('like',[LikeController::class,'store']);
    Route::delete('like-delete/{id}', [LikeController::class,'destroy']);

    //comment
    Route::post('comment',[CommentController::class,'store']);
});

Route::get('kategori',[KategoriController::class,'index']);

Route::get('gambar',[GambarController::class,'index']);
Route::get('gambar/{id}',[GambarController::class,'show']);

Route::get('dokter',[DokterController::class,'index']);

Route::get('supplier',[SupplierController::class,'index']);

Route::get('like/{id}',[LikeController::class,'show']);
Route::get('jumlah-like/{id}',[LikeController::class,'byGambar']);

Route::get('comment/{id}',[CommentController::class,'show']);

