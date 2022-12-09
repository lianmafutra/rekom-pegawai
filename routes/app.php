<?php

use App\Http\Controllers\MasterRekomController;
use App\Http\Controllers\Pegawai\PegawaiSyncController;
use App\Http\Controllers\Pengajuan\PengajuanAdminController;
use App\Http\Controllers\pengajuan\PengajuanOPDController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::prefix('admin')->middleware(['auth'])->group(function () {

   Route::get('pegawai/{nip}', [PegawaiSyncController::class, 'getPegawaiByNip'])->name('pegawai.nip');
   Route::get('pegawai', [PegawaiSyncController::class, 'getAll'])->name('pegawai.all');
   Route::get('pegawai/opd/{kunker}', [PegawaiSyncController::class, 'getByOPD'])->name('pegawai.opd');
   Route::get('pegawai/sync', [PegawaiSyncController::class, 'sync']);

   Route::prefix('pengajuan/verifikasi')->name('pengajuan.verifikasi.')->middleware(['auth'])->group(function () {
      Route::get('/', [PengajuanAdminController::class, 'index'])->name('index');
      Route::post('kirim', [PengajuanAdminController::class, 'kirim'])->name('kirim');
      Route::get('/{uuid}/detail', [PengajuanAdminController::class, 'detail'])->name('detail');
      

   });
   Route::resource('master-rekom', MasterRekomController::class);
   Route::resource('pengajuan', PengajuanOPDController::class);
   Route::get('pengajuan/histori/{uuid}', [PengajuanOPDController::class, 'histori'])->name('pengajuan.histori');

});
