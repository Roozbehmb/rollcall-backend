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

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');


Route::get('/user', function () {
    return auth()->user();
})->middleware('auth:api');


Route::group(['middleware' => 'auth:api'], function () {


    Route::get('test', [\App\Http\Controllers\Test::class, 'test']);

    Route::controller(\App\Http\Controllers\ShiftDailyController::class)->group(function () {
        Route::get('shiftDaily', 'index');
        Route::post('shiftDaily', 'store');
        Route::put('shiftDaily/{id}', 'update');
        Route::delete('shiftDaily/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\PeriodicShiftController::class)->group(function () {
        Route::get('periodicShift', 'index');
        Route::post('periodicShift', 'store');
        Route::put('periodicShift/{id}', 'update');
        Route::delete('periodicShift/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\WeeklyShiftController::class)->group(function () {
        Route::get('shiftWeek', 'index');
        Route::post('shiftWeek', 'store');
        Route::put('shiftWeek/{id}', 'update');
        Route::delete('shiftWeek/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\AbsenceController::class)->group(function () {
        Route::get('absence', 'index');
        Route::post('absence', 'store');
        Route::put('absence/{id}', 'update');
        Route::delete('absence/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\MissionController::class)->group(function () {
        Route::get('mission', 'index');
        Route::post('mission', 'store');
        Route::put('mission/{id}', 'update');
        Route::delete('mission/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\RulesOperationController::class)->group(function () {
        Route::get('workingRulesList', 'index');
        Route::post('workingRulesList', 'store');
        Route::put('workingRulesList/{id}', 'update');
        Route::delete('workingRulesList/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\SetAbsentController::class)->group(function () {
        Route::get('setAbsent', 'index');
        Route::post('setAbsent', 'store');
        Route::put('setAbsent/{id}', 'update');
        Route::delete('setAbsent/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\TrafficController::class)->group(function () {
        Route::get('traffic', 'index');
        Route::post('traffic', 'store');
        Route::put('traffic/{id}', 'update');
        Route::delete('traffic/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\ShiftEmployeeController::class)->group(function () {
        Route::get('ShiftAssignToEmployee', 'index');
        Route::get('ShiftAssignToEmployee/{id}', 'show');
        Route::post('ShiftAssignToEmployee', 'store');
        Route::put('ShiftAssignToEmployee/{id}', 'update');
        Route::delete('ShiftAssignToEmployee/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\MissionRegistrationController::class)->group(function () {
        Route::get('missionRegistration', 'index');
        Route::get('missionRegistration/{id}', 'show');
        Route::post('missionRegistration', 'store');
        Route::put('missionRegistration/{id}', 'update');
        Route::delete('missionRegistration/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\AssignWorkingRulesController::class)->group(function () {
        Route::get('assignWorkingRules', 'index');
        Route::get('assignWorkingRules/{id}', 'show');
        Route::post('assignWorkingRules', 'store');
        Route::put('assignWorkingRules/{id}', 'update');
        Route::delete('assignWorkingRules/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\WorkTermController::class)->group(function () {
        Route::get('workterm', 'index');
        Route::get('workterm/{id}', 'show');
        Route::post('workterm', 'store');
        Route::put('workterm/{id}', 'update');
        Route::delete('workterm/{id}', 'destroy');
    });

});


Route::get('test', [\App\Http\Controllers\HomeController::class, 'index']);


