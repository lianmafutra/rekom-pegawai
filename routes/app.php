<?php

use App\Http\Controllers\pengajuan\PengajuanOPDController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth'])->group(function () {
   Route::resource('pengajuan', PengajuanOPDController::class);
});