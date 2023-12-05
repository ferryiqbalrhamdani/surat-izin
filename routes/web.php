<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Data\DataCuti;
use App\Livewire\Data\DataIzin;
use App\Livewire\Data\DataLembur;
use App\Livewire\DataInput\IzinCuti;
use App\Livewire\DataInput\IzinCuti\Create as IzinCutiCreate;
use App\Livewire\DataInput\IzinLembur;
use App\Livewire\DataInput\IzinLembur\Create as IzinLemburCreate;
use App\Livewire\DataInput\SuratIzin;
use App\Livewire\DataInput\SuratIzin\Create;
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

    Route::get('/', Dashboard::class)->name('dashboard');

    // data input
    Route::get('/surat-izin', SuratIzin::class);
    Route::get('/surat-izin/tambah-data', Create::class);
    Route::get('/izin-lembur', IzinLembur::class);
    Route::get('/izin-lembur/tambah-data', IzinLemburCreate::class);
    Route::get('/izin-cuti', IzinCuti::class);
    Route::get('/izin-cuti/tambah-data', IzinCutiCreate::class);

    // data
    Route::get('/data-izin', DataIzin::class);
    Route::get('/data-cuti', DataCuti::class);
    Route::get('/data-lembur', DataLembur::class);


    // data master
    Route::get('/role', Role::class);
    Route::get('/pt', DataPt::class);
    Route::get('/divisi', DataDivisi::class);
    Route::get('/user', DataUser::class);
});
