<?php

namespace App\Http\Services\Pegawai;

use Illuminate\Support\Facades\Cache;

class PegawaiService
{
   public function sync()
   {
      $pegawai = Cache::get('pegawai');
      if (Cache::has('pegawai') == false || $pegawai== null) {
         $url = 'https://presensi.jambikota.go.id/api/Absen?ABSEN-API-KEY=kominfo';
         $response = Http::withBasicAuth('absen', 'absen2022')->acceptJson()->get($url)->collect();
         $pegawai = Cache::forever('pegawai', $response);
      } 
   }
   
   public function filterByNIP($nip)
   {
      $pegawai = Cache::get('pegawai')->where('nipbaru', $nip)->values()->toArray();
      return response()->json($pegawai[0]);
   }

   public function filterByOPD($kunker)
   {
      // sample kominfo
      $pegawai = Cache::get('pegawai')->where('kunker', $kunker)->values()->toArray();
      return $pegawai;
   }
}
