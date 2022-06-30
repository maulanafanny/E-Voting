<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VotersController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', [UserController::class, 'index']);
Route::get('/votinglogin', [UserController::class, 'votinglogin'])->name('votinglogin');

/** Admin Route */
Route::get('/admin', [DashboardController::class, 'index'])->name('home');
Route::get('/admin/buka', [DashboardController::class, 'buka'])->name('admin.buka');
Route::get('/admin/tutup', [DashboardController::class, 'tutup'])->name('admin.tutup');
Route::post('/admin/postlogin', [AuthController::class, 'postlogin']);
Route::get('/admin/export_excel', [KandidatController::class, 'export_excel'])->name('admin.kandidat.export_excel');

// Route Kandidat
Route::get('/admin/kandidat', [KandidatController::class, 'index'])->name('admin.kandidat');
Route::get('/admin/kandidat/tambah', [KandidatController::class, 'tambah'])->name('admin.kandidat.tambah');
Route::get('/admin/kandidat/detail/{id}', [KandidatController::class, 'detail'])->name('admin.kandidat.detail');
Route::get('/admin/kandidat/edit/{id}', [KandidatController::class, 'edit'])->name('admin.kandidat.edit');
Route::post('/admin/kandidat/update/{id}', [KandidatController::class, 'update'])->name('admin.kandidat.update');
Route::get('/admin/kandidat/hapus/{id}', [KandidatController::class, 'hapus'])->name('admin.kandidat.hapus');
Route::post('/admin/kandidat/store', [KandidatController::class, 'store'])->name('admin.kandidat.store');

// Route Voters
Route::get('/admin/voters', [VotersController::class, 'index'])->name('admin.voters');
Route::get('/admin/voters/tambah', [VotersController::class, 'tambah'])->name('admin.voters.tambah');
Route::post('/admin/voters/store', [VotersController::class, 'store'])->name('admin.voters.store');
Route::get('/admin/voters/hapus', [VotersController::class, 'hapus'])->name('admin.voters.hapus');
Route::post('/admin/voters/delete', [VotersController::class, 'delete'])->name('admin.voters.delete');
Route::get('/admin/voters/export_excel', [VotersController::class, 'export_excel'])->name('admin.voters.export_excel');

// Route Voting
Route::get('/voting', [VotingController::class, 'index'])->name('voting');
Route::post('/cektoken', [UserController::class, 'cektoken'])->name('cektoken');
Route::get('/simpansuara/{id}', [VotingController::class, 'simpansuara'])->name('simpansuara');
Route::get('/logoutvoting', [VotingController::class, 'logoutvoting'])->name('logoutvoting');
Route::get('/hasilvoting', [UserController::class, 'hasilvoting'])->name('hasilvoting');

Auth::routes();