<?php

use App\Http\Controllers\Pegawai\PegawaiSyncController;
use App\Http\Controllers\Pengajuan\PengajuanAdminController;
use App\Http\Controllers\pengajuan\PengajuanOPDController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth'])->group(function () {

  
 
  
   Route::group(['middleware' => ['role:superadmin']], function () {
      Route::resource('pengajuan', PengajuanOPDController::class);
  });
  Route::group(['middleware' => ['role:admin_opd']], function () {
   Route::resource('pengajuan', PengajuanAdminController::class);
});
});
