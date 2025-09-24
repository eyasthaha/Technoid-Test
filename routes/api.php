<?php

use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PartnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);




Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::middleware('role:partner_admin')->group(function () {
        
        Route::get('/partners', [PartnerController::class, 'list']);
        Route::get('/partners/{id}', [PartnerController::class, 'get']);

        Route::get('/clinics', [ClinicController::class, 'list']);


    });

    Route::middleware('role:partner_admin,clinic_admin')->group(function () {

       

        Route::get('/doctors', [DoctorController::class, 'list']);
        Route::post('/doctors', [ClinicController::class, 'create']);
        Route::put('/doctors/{id}', [ClinicController::class, 'updateDoctorStatus']);

    });

});