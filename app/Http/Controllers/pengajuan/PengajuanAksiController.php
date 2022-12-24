<?php

namespace App\Http\Controllers\Pengajuan;

use App\Config\RekomJenis;
use App\Config\SuratTtd;
use App\Http\Controllers\Controller;
use App\Http\Requests\CetakRekomRequest;
use App\Http\Services\Surat\SuratCetak;
use App\Models\Pengajuan;
use App\Models\User;
use App\Utils\ApiResponse;
use App\Utils\TempFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use ZipArchive;

use function Termwind\render;

class PengajuanAksiController extends Controller
{

   use ApiResponse;

   public function cetakRekom(CetakRekomRequest $request, User $user, Pengajuan $pengajuan)
   {

      // abort_if(Gate::denies('rekom cetak'), 403);

      try {
         DB::beginTransaction();
         $suratCetak = new SuratCetak();
         $suratCetak
            ->setPengajuan($pengajuan->getPengajuanWithData($request->pengajuan_uuid))
            ->setRekomJenis('')
            ->setTTD(SuratTtd::TTD_MANUAL)
            ->cetaksurat()
            ->updatefileRekom();
           

            DB::commit();
         return $this->success('Sukses');

       
      } catch (\Throwable $th) {
         return $this->error('gagal' . $th, 400);
         DB::rollBack();
      }
   }


   public function verifikasiQR($pengajuan_uuid,)
   {
      $pengajuan = Pengajuan::where('uuid', $pengajuan_uuid)->first();
      if ($pengajuan) {
         return dd($pengajuan);
      } else {
         return dd('Data Pengajuan tidak ditemukan dalam sistem');
      }
   }
}
