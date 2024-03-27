<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
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

Route::group(["prefix"=> "employees"], function () {
    Route::get("all", [EmployeeController::class,'index']);
    Route::post("create", [EmployeeController::class,'create']);
    Route::patch("update/{id}", [EmployeeController::class,'update']);
    Route::get("search", [EmployeeController::class,'search']);
    Route::get("show/{id}", [EmployeeController::class,'show']);
    Route::delete("delete/{id}", [EmployeeController::class,'delete']);
});

Route::group(["prefix"=> "roles"], function () {
    Route::post("create", [AdminController::class,'createRole']);
    Route::patch("update/{id}", [AdminController::class,'updateEmployeeStatus']);
    Route::patch("update/{id}", [AdminController::class,'updateEmployeeStatus']);
    Route::post("assign", [AdminController::class,'assignRole']);
});
Route::group(["prefix"=> "admin"], function () {
    Route::get("dashboard", [AdminController::class,'adminDashboard']);
});