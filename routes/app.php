<?php

<<<<<<< HEAD
use App\Http\Controllers\Pegawai\PegawaiSyncController;
use App\Http\Controllers\pengajuan\PengajuanOPDController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth'])->group(function () {
   Route::resource('pengajuan', PengajuanOPDController::class);
   Route::get('pegawai/{nip}', [PegawaiSyncController::class, 'getPegawaiByNip'])->name('pegawai.nip');

});
=======

use Illuminate\Support\Facades\Route;


Route::get('testing/', function () {
   return view('welcome');
})->name('index');
>>>>>>> starter-project
