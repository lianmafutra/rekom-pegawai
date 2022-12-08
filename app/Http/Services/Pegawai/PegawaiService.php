<?php

namespace App\Http\Services\Pegawai;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class PegawaiService
{
   public function sync()
   {
      $pegawai = Cache::get('pegawai');
      if (Cache::has('pegawai') == false || $pegawai == null) {
         $url = Config::get('global.url.bkd.pegawai');
         $response = Http::withBasicAuth('absen', 'absen2022')->acceptJson()->get($url)->collect();
         $pegawai = Cache::forever('pegawai', $response);
      }
   }

   public function filterByNIP($nip)
   {
      $pegawai = Cache::get('pegawai')->where('nipbaru', $nip)->values()->toArray();
      return $pegawai;
   }

   public function filterByOPD($kunker)
   {
      $pegawai = Cache::get('pegawai')->where('kunker', $kunker)->values()->toArray();
      return $pegawai;
   }

   public function getAll(){
      $pegawai = Cache::get('pegawai')->values()->toArray();
      return $pegawai;
   }
}
