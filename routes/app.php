<?php

use App\Http\Controllers\Pegawai\PegawaiSyncController;
use App\Http\Controllers\pengajuan\PengajuanOPDController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth'])->group(function () {
  
   Route::get('pegawai/{nip}', [PegawaiSyncController::class, 'getPegawaiByNip'])->name('pegawai.nip');

   Route::resource('pengajuan', PengajuanOPDController::class);
   Route::get('pengajuan/histori/{uuid}', [PengajuanOPDController::class, 'histori'])->name('pengajuan.histori');

});
