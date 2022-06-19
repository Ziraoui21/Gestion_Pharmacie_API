<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntreeController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\MedicamentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentesController;
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


Route::group(['middleware' => 'auth:sanctum'],function(){

    Route::group(['prefix' => 'dashboard'],function(){
        Route::get('infos',[DashboardController::class,'get_infos']);
    });

    Route::group(['prefix'=>'auth'],function(){
        Route::post('edit',[AuthController::class,'edittUser']);
        Route::get('logout',[AuthController::class,'logout']);
    });

    Route::group(['prefix'=>'users'],function(){
        Route::get('all',[UserController::class,'users']);
        Route::post('create',[UserController::class,'create']);
        Route::post('delete',[UserController::class,'delete']);
        Route::post('setadmin',[UserController::class,'setAdmin']);
    });

    Route::group(['prefix' => 'clients'],function(){
        Route::get('all',[ClientController::class,'clients']);
        Route::post('create',[ClientController::class,'create']);
        Route::post('update',[ClientController::class,'update']);
        Route::post('delete',[ClientController::class,'delete']);
    });

    Route::group(['prefix' => 'medicaments'],function(){
        Route::get('all',[MedicamentController::class,'medicaments']);
        Route::get('fournisseurs',[MedicamentController::class,'getFournisseurs']);
        Route::post('create',[MedicamentController::class,'create']);
        Route::post('update',[MedicamentController::class,'update']);
        Route::post('delete',[MedicamentController::class,'delete']);
    });

    Route::group(['prefix' => 'fournisseurs'],function(){
        Route::get('all',[FournisseurController::class,'fournisseurs']);
        Route::post('create',[FournisseurController::class,'create']);
        Route::post('update',[FournisseurController::class,'update']);
    });

    Route::group(['prefix' => 'entrees'],function(){
        Route::get('all',[EntreeController::class,'medicaments']);
        Route::post('create',[EntreeController::class,'create']);
    });

    Route::group(['prefix' => 'factures'],function(){
        Route::get('all',[FactureController::class,'factures']);
        Route::post('confirmer',[FactureController::class,'confirmer']);
        Route::post('calculer',[FactureController::class,'calcul']);
    });

    Route::group(['prefix' => 'stock'],function(){
        Route::get('medicaments',[StockController::class,'medicaments']);
        Route::post('commander',[StockController::class,'commander']);
    });

    Route::group(['prefix' => 'ventes'],function(){
        Route::get('all',[VentesController::class,'ventes']);
    });

    Route::group(['prefix' => 'achats'],function(){
        Route::get('medicaments',[AchatController::class,'medicaments']);
        Route::get('clients',[AchatController::class,'clients']);
        Route::post('sortie',[AchatController::class,'create_sortie']);
        Route::post('facture',[AchatController::class,'create_facture']);
    });
});

Route::group(['middleware'=> 'guest'],function(){
    Route::post('auth/login',[AuthController::class,'login']);
});