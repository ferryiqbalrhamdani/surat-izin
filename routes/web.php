<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\DataMaster\DataDivisi;
use App\Livewire\DataMaster\DataPt;
use App\Livewire\DataMaster\DataUser;
use App\Livewire\DataMaster\Role;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/login', Login::class)->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::get('/', Dashboard::class)->name('dashboard')->middleware('can:view_dashboard');
    Route::get('/role', Role::class)->middleware('can:view_data_role');
    Route::get('/pt', DataPt::class)->middleware('can:view_data_pt');
    Route::get('/divisi', DataDivisi::class)->middleware('can:view_data_divisi');
    Route::get('/user', DataUser::class)->middleware('can:view_data_user');
});
