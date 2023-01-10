<?php

use App\Http\Controllers\MasterRekomController;
use App\Http\Controllers\MasterUserController;
use App\Http\Controllers\Pegawai\PegawaiSyncController;
use App\Http\Controllers\Pengajuan\PengajuanAdminController;
use App\Http\Controllers\Pengajuan\PengajuanAksiController;
use App\Http\Controllers\pengajuan\PengajuanOPDController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::prefix('admin')->middleware(['auth'])->group(function () {

   Route::get('pegawai/{nip}', [PegawaiSyncController::class, 'getPegawaiByNip'])->name('pegawai.nip');
   Route::get('pegawai', [PegawaiSyncController::class, 'getAll'])->name('pegawai.all');
   Route::get('pegawai/opd/{kunker}', [PegawaiSyncController::class, 'getByOPD'])->name('pegawai.opd');
   Route::get('pegawai/sync', [PegawaiSyncController::class, 'sync']);

   // Route::controller(PengajuanAksiController::class)->name('pengajuan.aksi.')->prefix('pengajuan/aksi')->group(function () {
   //    Route::get('pegawai/sync', [PegawaiSyncController::class, 'sync']);
      
   // });

  
   Route::get('pegawai/verifikasi/pelanggaran/{nip}', [PegawaiSyncController::class, 'verifikasiPelanggaran'])->name('pegawai.verifikasi.pelanggaran');

   Route::prefix('pengajuan/verifikasi')->name('pengajuan.verifikasi.')->middleware(['auth'])->group(function () {
      Route::get('/', [PengajuanAdminController::class, 'index'])->name('index');
      Route::delete('destroy/{uuid}', [PengajuanAdminController::class, 'destroy'])->name('destroy');
      Route::get('/{uuid}/detail', [PengajuanAdminController::class, 'detail'])->name('detail');
   });


   Route::controller(PengajuanAksiController::class)->name('pengajuan.aksi.')->prefix('pengajuan/aksi')->middleware(['auth'])->group(function () {
      Route::post('cetak-rekom',  'cetakRekom')->name('cetak');
      Route::post('preview-rekom',  'previewRekom')->name('preview');
      Route::post('meneruskan',  'meneruskan')->name('meneruskan');
      Route::post('tolak',  'tolak')->name('tolak');
      Route::post('selesai',  'selesai')->name('selesai');
   });
  
   Route::resource('pengajuan', PengajuanOPDController::class);
   Route::resource('master-rekom', MasterRekomController::class);

   Route::post('master-user/password/reset', [MasterUserController::class, 'resetPassword'])->name('master-user.password.reset');
   Route::get('master-user/penanda-tangan', [MasterUserController::class, 'indexPenandaTangan'])->name('master-user.ttd');
   Route::put('master-user/penanda-tangan/update/{uuid}', [MasterUserController::class, 'updateUserTTD'])->name('master-user.ttd.update');
   Route::resource('master-user', MasterUserController::class);
   
   Route::get('pengajuan/revisi/{uuid}',[PengajuanOPDController::class, 'revisi'])->name('pengajuan.revisi');
   Route::put('pengajuan/revisi/update',[PengajuanOPDController::class, 'updateRevisi'])->name('pengajuan.revisi.update');

   Route::get('pengajuan/histori/{uuid}', [PengajuanOPDController::class, 'histori'])->name('pengajuan.histori');
   
   Route::put('profile', [UserController::class, 'profileUpdate'])->name('profile.update');

});

Route::get('pengajuan/aksi/verifikasi/QR/{uuid}', [PengajuanAksiController::class, 'verifikasiQR'])->name('pengajuan.aksi.verifikasi');
Route::get('link/{id}', [PengajuanAksiController::class, 'shortUrl'])->name('pengajuan.aksi.link');
