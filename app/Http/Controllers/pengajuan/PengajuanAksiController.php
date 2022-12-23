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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;

use function Termwind\render;

class PengajuanAksiController extends Controller
{

   use ApiResponse;

   public function cetakRekom(CetakRekomRequest $request, User $user, SuratCetak $suratCetak, Pengajuan $pengajuan)
   {

      // abort_if(Gate::denies('rekom cetak'), 403);

      try {
         DB::beginTransaction();

         $suratCetak
            ->pengajuan($pengajuan->getPengajuanWithData($request->pengajuan_uuid))
            ->surat('', '', '', '', '')
            ->rekomJenis('')
            ->ttd(SuratTtd::TTD_MANUAL)
            ->cetak();

         // return $this->success($suratCetak);

         DB::commit();
      } catch (\Throwable $th) {
         return $this->error('gagal' . $th, 400);
         DB::rollBack();
      }
   }


   public function verifikasiQR($pengajuan_uuid)
   {
      // $qrcode = QrCode::size(400)->generate('dqqdqw');
      // $temp_data = current((array) $qrcode);
      // $temp_path =  pathinfo($temp_data);
      // $path = stream_get_meta_data(  $temp_data); 
      // $temp_path =  pathinfo($temp_data->filename);
      // $filename = $temp_path['filename'];
      $qrCode = QrCode::create('Life is too short to be generating QR codes','');
      // header('Content-Type: '.$qrCode->getMimeType());
      dd($qrCode->getString());
      // $file = tmpfile();
      // $path = stream_get_meta_data($qrcode); // eg: /tmp/phpFx0513a
    
      // $temp = tmpfile();
      // fwrite($temp, file_get_contents( $qrcode));
      
     
      $pengajuan = Pengajuan::where('uuid', $pengajuan_uuid)->first();
      if($pengajuan){
         return dd($pengajuan);
      }else{
         return dd('Data Pengajuan tidak ditemukan dalam sistem');
      }
   }
}
