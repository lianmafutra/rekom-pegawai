<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Services\Pegawai\PegawaiService;
use App\Models\MasterRekom;

class PegawaiSyncController extends Controller
{

   public function getPegawaiByNip($nip, PegawaiService $pegawaiService)
   {

      return response()->json($pegawaiService->filterByNIP($nip)[0]);
   }

   public function getAll(PegawaiService $pegawaiService)
   {

      return response()->json($pegawaiService->getAll());
   }

   public function getByOPD(PegawaiService $pegawaiService, $kunker)
   {

      return response()->json($pegawaiService->filterByOPD($kunker));
   }

   public function sync(PegawaiService $pegawaiService)
   {
      return $pegawaiService->sync();
   }

   public function verifikasiPelanggaran($nip)
   {
      $hasil = MasterRekom::where('nip', $nip)->get();
      return response()->json($hasil);
   }
}
