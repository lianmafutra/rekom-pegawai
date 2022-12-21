<?php

namespace App\Http\Controllers\Pengajuan;

use App\Config\RekomJenis;
use App\Config\SuratTtd;
use App\Http\Controllers\Controller;
use App\Http\Requests\CetakRekomRequest;
use App\Http\Services\Surat\SuratCetak;
use App\Models\User;
use App\Utils\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PengajuanAksiController extends Controller
{

   use ApiResponse;

    public function cetakRekom(CetakRekomRequest $request, User $user, SuratCetak $suratCetak){

      // abort_if(Gate::denies('rekom cetak'), 403);

      try {
         DB::beginTransaction();
        
         $suratCetak
         ->pengajuan($request->pengajuan_uuid)
         ->surat('','', '', '','')
         ->rekomJenis('')
         ->ttd(SuratTtd::TTD_MANUAL)
         ->cetak();

         return $this->success($suratCetak);

         DB::commit();
      } catch (\Throwable $th) {
         return $this->error('gagal' .$th, 400);

         DB::rollBack();
         throw $th;
      }

    }

}
