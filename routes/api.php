<?php

use App\Http\Controllers\EmpresaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('empresas')->group(function () {
    Route::post('/', [EmpresaController::class, 'store']);
    Route::put('{nit}', [EmpresaController::class, 'update']);
    Route::get('{nit}', [EmpresaController::class, 'show']);
    Route::get('/', [EmpresaController::class, 'index']);
    Route::delete('{nit}', [EmpresaController::class, 'destroy']);
});

