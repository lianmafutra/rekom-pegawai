<?php

use App\Http\Controllers\MasterRekomController;
use App\Http\Controllers\MasterUserController;
use App\Http\Controllers\Pegawai\PegawaiSyncController;
use App\Http\Controllers\Pengajuan\PengajuanAdminController;
use App\Http\Controllers\Pengajuan\PengajuanAksiController;
use App\Http\Controllers\pengajuan\PengajuanOPDController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::prefix('admin')->middleware(['auth'])->group(function () {

   Route::get('pegawai/{nip}', [PegawaiSyncController::class, 'getPegawaiByNip'])->name('pegawai.nip');
   Route::get('pegawai', [PegawaiSyncController::class, 'getAll'])->name('pegawai.all');
   Route::get('pegawai/opd/{kunker}', [PegawaiSyncController::class, 'getByOPD'])->name('pegawai.opd');
   Route::get('pegawai/sync', [PegawaiSyncController::class, 'sync']);
   Route::get('pegawai/verifikasi/pelanggaran/{nip}', [PegawaiSyncController::class, 'verifikasiPelanggaran'])->name('pegawai.verifikasi.pelanggaran');

   Route::prefix('pengajuan/verifikasi')->name('pengajuan.verifikasi.')->middleware(['auth'])->group(function () {
      Route::get('/', [PengajuanAdminController::class, 'index'])->name('index');
      Route::delete('destroy/{uuid}', [PengajuanAdminController::class, 'destroy'])->name('destroy');
      Route::get('/{uuid}/detail', [PengajuanAdminController::class, 'detail'])->name('detail');
   });
   Route::resource('master-rekom', MasterRekomController::class);


   Route::prefix('pengajuan/aksi')->name('pengajuan.aksi.')->middleware(['auth'])->group(function () {
      Route::post('cetak-rekom', [PengajuanAksiController::class, 'cetakRekom'])->name('cetak');
      Route::post('meneruskan', [PengajuanAksiController::class, 'meneruskan'])->name('meneruskan');
      Route::post('tolak', [PengajuanAksiController::class, 'tolak'])->name('tolak');
      Route::post('selesai', [PengajuanAksiController::class, 'selesai'])->name('selesai');
   });
  

   
   Route::resource('pengajuan', PengajuanOPDController::class);
   
   Route::resource('master-user', MasterUserController::class);
   Route::post('master-user/password/reset', [MasterUserController::class, 'resetPassword'])->name('master-user.password.reset');

   Route::get('pengajuan/revisi/{uuid}',[PengajuanOPDController::class, 'revisi'])->name('pengajuan.revisi');
   Route::put('pengajuan/revisi/update',[PengajuanOPDController::class, 'updateRevisi'])->name('pengajuan.revisi.update');

   Route::get('pengajuan/histori/{uuid}', [PengajuanOPDController::class, 'histori'])->name('pengajuan.histori');

});


Route::get('pengajuan/aksi/verifikasi/QR/{uuid}', [PengajuanAksiController::class, 'verifikasiQR'])->name('pengajuan.aksi.verifikasi');
Route::get('link/{id}', [PengajuanAksiController::class, 'shortUrl'])->name('pengajuan.aksi.link');
