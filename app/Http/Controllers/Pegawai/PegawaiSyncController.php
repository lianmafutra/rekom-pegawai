<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PegawaiSyncController extends Controller
{


   public function getApiFromBKD()
   {
      
   }

   public function getPegawaiByNip($nip){
      $pegawai = Cache::get('pegawai')->where('nipbaru', $nip)->values();
      return response()->json($pegawai[0]);
   }
}
