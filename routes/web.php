<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Data\DataIzin;
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

    Route::get('/', Dashboard::class)->name('dashboard')->middleware('can:view_dashboard');

    // data input
    Route::get('/surat-izin', SuratIzin::class)->middleware('can:view_surat_izin');
    Route::get('/surat-izin/tambah-data', Create::class)->middleware('can:view_surat_izin');
    Route::get('/izin-lembur', IzinLembur::class)->middleware('can:view_izin_lembur');
    Route::get('/izin-lembur/tambah-data', IzinLemburCreate::class)->middleware('can:view_izin_lembur');
    Route::get('/izin-cuti', IzinCuti::class)->middleware('can:view_izin_cuti');
    Route::get('/izin-cuti/tambah-data', IzinCutiCreate::class)->middleware('can:view_izin_cuti');

    // data
    Route::get('/data-izin', DataIzin::class);


    // data master
    Route::get('/role', Role::class)->middleware('can:view_data_role');
    Route::get('/pt', DataPt::class)->middleware('can:view_data_pt');
    Route::get('/divisi', DataDivisi::class)->middleware('can:view_data_divisi');
    Route::get('/user', DataUser::class)->middleware('can:view_data_user');
});
