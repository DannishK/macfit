<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\VerifyEmaliController;
use App\Http\Controllers\ResendEmailVerificationController;

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

Route::get('/email/verify/{id}/{hash}',[VerifyEmaliController::class, 'verify'])
->name('verification.verify')
->middleware(['signed','throttle:6,1']);

Route::post('/email/resend',[ResendEmailVerificationController::class, 'resend'])
->middleware('throttle:6,1');

Route::middleware('auth:sanctum')->group(function () {
    
Route::post('/logout',[AuthController::class, 'logout']);

Route::post('/saveRoles',[RoleController::class, 'createRole']);
Route::get('/getRoles',[RoleController::class, 'readAllRoles']);
Route::get('/getRole/{id}',[RoleController::class, 'readRole']);
Route::post('/updateRole/{id}',[RoleController::class, 'updateRole']);
Route::delete('/deleteRole/{id}',[RoleController::class, 'deleteRole']);


Route::post('/saveCategory',[CategoryController::class, 'createCategory']);
Route::get('/getCategory',[CategoryController::class, 'readAllCategory']);
Route::get('/getCategory/{id}',[CategoryController::class, 'readCategory']);
Route::post('/updateCategory/{id}',[CategoryController::class, 'updateCategory']);
Route::delete('/deleteCategory/{id}',[CategoryController::class, 'deleteCategory']);

Route::post('/savegym',[GymController::class, 'createGym']);
Route::get('/getgyms',[GymController::class, 'readAllGyms']);
Route::get('/getgym/{id}',[GymController::class, 'readGym']);
Route::post('/updategym/{id}',[GymController::class, 'updateGym']);
Route::delete('/deletegym/{id}',[GymController::class, 'deleteGym']);

Route::post('/saveBundle',[BundleController::class, 'createBundle']);
Route::get('/getBundles',[BundleController::class, 'readAllBundles']);
Route::get('/getBundle/{id}',[BundleController::class, 'readBundle']);
Route::post('/updateBundle/{id}',[BundleController::class, 'updateBundle']);
Route::delete('/deleteBundle/{id}',[BundleController::class, 'deleteBundle']);

Route::post('/saveEquipment',[EquipmentController::class, 'createEquipment']);
Route::get('/getEquipments',[EquipmentController::class, 'readAllEquipments']);
Route::get('/getEquipment/{id}',[EquipmentController::class, 'readEquipment']);
Route::post('/updateEquipment/{id}',[EquipmentController::class, 'updateEquipment']);
Route::delete('/deleteEquipment/{id}',[EquipmentController::class, 'deleteEquipment']);

Route::post('/saveSubscription',[SubscriptionController::class, 'createSubscription']);
Route::get('/getSubscriptions',[SubscriptionController::class, 'readAllSubscriptions']);
Route::get('/getSubscription/{id}',[SubscriptionController::class, 'readSubscription']);
Route::post('/updateSubscription/{id}',[SubscriptionController::class, 'updateSubscription']);
Route::delete('/deleteSubscription/{id}',[SubscriptionController::class, 'deleteSubscription']);

});