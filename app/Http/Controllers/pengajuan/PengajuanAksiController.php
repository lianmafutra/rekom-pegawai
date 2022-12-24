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
       (new SuratCetak())
            ->setPengajuan($pengajuan->getPengajuanWithData($request->pengajuan_uuid))
            ->setRekomJenis('')
            ->setTTD(SuratTtd::TTD_MANUAL)
            ->cetaksurat()
            ->updatefileRekom();

            DB::commit();
         return $this->success('Sukses');
      } catch (\Throwable $th) {
         DB::rollBack();
         return $this->error('gagal' . $th, 400);
      }
   }

   public function shortUrl($id)
   {

      $pengajuan = Pengajuan::where('short_url', $id)->first();

      if ($pengajuan) {
         return redirect()->route('pengajuan.aksi.verifikasi',  $pengajuan->uuid);
      } else {
         return dd('Data Pengajuan tidak ditemukan dalam sistem');
      }
   }


   public function verifikasiQR($pengajuan_uuid)
   {


      $pengajuan = Pengajuan::where('uuid', $pengajuan_uuid)->first();
    
      $x['title'] = 'Validasi Berkas';
       
      return view('pengajuan.verifikasi.QR-verifikasi', $x, compact('pengajuan'));
   }
}
