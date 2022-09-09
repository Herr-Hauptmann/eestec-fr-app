<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('auth.login');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
// Route::middleware(['auth:sanctum', 'verified'])->get('/companies', function () {
//     return view('company');
// })->name('companies');


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', [RoleController::class, 'dashboard'])->name('dashboard');


    Route::get('/companies', [CompanyController::class, 'index'])->name('companies');
    Route::get('/companies/search', [CompanyController::class, 'search'])->name('companies.search');
    Route::get('/companies/edit/{id}', [CompanyController::class, 'edit']);
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::get('/companies/{id}', [CompanyController::class, 'show']);
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::put('/companies/{id}', [CompanyController::class, 'update']);
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');

    Route::get('/events', [EventController::class, 'index'])->name('events');
    Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
    Route::get('/events/edit/{id}', [EventController::class, 'edit']);
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::get('/events/{id}/filterStatuses', [EventController::class, 'filterStatuses'])->name('event.filterStatuses');
    Route::get('/events/{id}/filter', [EventController::class, 'filter'])->name('event.filter');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::post('/status', [StatusController::class, 'store'])->name('status.store');
    Route::delete('/status/{id}', [StatusController::class, 'destroy'])->name('status.destroy');
    Route::put('/status/update/{id}', [StatusController::class, 'update']);
    Route::put('/status/updateStatus/{id}', [StatusController::class, 'updateStatus']);
    
    Route::get('/users', [RoleController::class, 'index'])->name('users');
    Route::get('/users/search', [RoleController::class, 'search'])->name('users.search');
    Route::put('/users/{id}', [RoleController::class, 'verify'])->name('users.verify');
    Route::put('/users/update/{id}', [RoleController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [RoleController::class, 'destroy'])->name('users.destroy');
    
    Route::get('/companies/status/{id}', [StatusController::class, 'show'])->name('status.show');
    Route::get('/companies/getReports/{status_id}', [ReportController::class, 'getReports'])->name('getReports');
    Route::post('/reports/{id}', [ReportController::class, 'store'])->name('reports.store');
});
