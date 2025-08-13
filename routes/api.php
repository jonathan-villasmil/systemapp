<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;


// use App\Http\Controllers\API\UserPermissionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password',  [AuthController::class, 'resetPassword']);
Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    //Route::post('/assign-role', [UserPermissionController::class, 'assignRole']);

});

//Route::post('/roles', [RoleController::class, 'store']);


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Route::get('/admin-only', [AdminController::class, 'index']);

    Route::apiResource('roles', RoleController::class);
    Route::post('/users/{userId}/assign-role', [RoleController::class, 'assignRole']);
    Route::post('/users/{userId}/remove-role', [RoleController::class, 'removeRole']);


    Route::apiResource('permissions', PermissionController::class);
    Route::post('/give-permission', [PermissionController::class, 'givePermission']);
    Route::post('/revoke-permission', [PermissionController::class, 'revokePermission']);
    //Route::get('/roles-permissions', [UserPermissionController::class, 'getUserRolesPermissions']);










});

Route::middleware(['auth:sanctum', 'role:client'])->group(function () {
    // carta
    //reservas
    //login y registro
    //información general de los puntos de venta
});
