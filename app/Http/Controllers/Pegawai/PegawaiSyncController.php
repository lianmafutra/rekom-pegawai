<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Services\Pegawai\PegawaiService;

class PegawaiSyncController extends Controller
{

   public function getPegawaiByNip($nip, PegawaiService $pegawaiService){
      
      return response()->json($pegawaiService->filterByNIP($nip)[0]);
   }
}
