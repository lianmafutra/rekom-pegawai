<?php

namespace App\Http\Controllers\Pengajuan;

use App\Config\PengajuanAksi;
use App\Config\RekomJenis;
use App\Config\SuratTtd;
use App\Http\Controllers\Controller;
use App\Http\Requests\CetakRekomRequest;
use App\Http\Services\Pegawai\PengajuanService;
use App\Http\Services\Surat\SuratCetak;
use App\Models\Pengajuan;
use App\Models\PengajuanHistori;
use App\Models\User;
use App\Utils\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PengajuanAksiController extends Controller
{

   use ApiResponse;
   private $pengajuanService;
   public function __construct(PengajuanService $pengajuanService)
   {
      $this->pengajuanService = $pengajuanService;
   }

   public function cetakRekom(CetakRekomRequest $request, User $user, Pengajuan $pengajuan)
   {

      abort_if(Gate::denies('rekom cetak'), 403);
      try {
         DB::beginTransaction();

         (new SuratCetak())
            ->setPengajuan($pengajuan->getPengajuanWithData($request->pengajuan_uuid))
            ->setRekomJenis(RekomJenis::DISIPLIN)
            ->setTTD(SuratTtd::TTD_MANUAL)
            ->cetaksurat()
            ->updatefileRekom();

         $this->pengajuanService->updateTglAksiPengajuanHistori($request->pengajuan_uuid);
         (new PengajuanService())->storeHistori($request->pengajuan_uuid, PengajuanAksi::MENERUSKAN, $request->penerima_uuid);
         (new PengajuanService())->storeHistori($request->pengajuan_uuid, PengajuanAksi::PROSES_SURAT, $request->penerima_uuid);

         DB::commit();
         return $this->success('Sukses');
      } catch (\Throwable $th) {
         DB::rollBack();
         return $this->error('gagal' . $th, 400);
      }
   }


   public function meneruskan(Request $request)
   {
      try {

         $this->pengajuanService->updateTglAksiPengajuanHistori($request->pengajuan_uuid);

         $this->pengajuanService->storeHistori(
            $request->pengajuan_uuid,
            PengajuanAksi::MENERUSKAN,
            $request->penerima_uuid
         );

         DB::commit();
         return redirect()->back()->with('success-modal', ['title' => 'Berhasil', 'message' => 'Berhasil Meneruskan Berkas'], 200)->send();
      } catch (\Throwable $th) {
         DB::rollback();
         return redirect()->back()->with('error-modal', 'Gagal : ' . $th->getMessage(), 400)->send();
      }
   }

   public function tolak(Request $request)
   {
      try {
         $penerima  = Pengajuan::with('pengirim')
            ->where('uuid', '=', $request->pengajuan_uuid)
            ->first();

         $user_pengirim_opd_uuid  = User::find($penerima->pengirim_id)->uuid;

         $this->pengajuanService->updateTglAksiPengajuanHistori($request->pengajuan_uuid);
         $this->pengajuanService->storeHistori(
            $request->pengajuan_uuid,
            PengajuanAksi::TOLAK,
            $user_pengirim_opd_uuid,
            $request->pesan
         );

         DB::commit();
         return redirect()->back()->with('success-modal', ['title' => 'Berhasil', 'message' => 'Berhasil Menolak Berkas'], 200)->send();
      } catch (\Throwable $th) {
         DB::rollback();
         return redirect()->back()->with('error-modal', 'Gagal : Menolak Berkas', 400)->send();
      }
   }


   public function selesai(Request $request)
   {
      try {
         // OPD asal Pengirim
         $penerima  = Pengajuan::with('pengirim')
            ->where('uuid', '=', $request->pengajuan_uuid)
            ->first();

         $user_pengirim_opd_uuid  = User::find($penerima->pengirim_id)->uuid;

         $this->pengajuanService->updateTglAksiPengajuanHistori($request->pengajuan_uuid);
         $this->pengajuanService->storeHistori(
            $request->pengajuan_uuid,
            PengajuanAksi::SELESAI,
            $user_pengirim_opd_uuid
         );

         DB::commit();
         return redirect()->back()->with('success-modal', ['title' => 'Berhasil', 'message' => 'Pengajuan Berkas berhasil diselesaikan'], 200)->send();
      } catch (\Throwable $th) {
         DB::rollback();
         return redirect()->back()->with('error-modal', 'Gagal : Menolak Berkas', 400)->send();
      }
   }

   public function shortUrl($id)
   {
      $pengajuan = Pengajuan::where('short_url', $id)->first();

      if ($pengajuan) {
         return redirect()->route('pengajuan.aksi.verifikasi',  $pengajuan->uuid);
      }
      return abort(404);
   }


   public function verifikasiQR($pengajuan_uuid)
   {
      $pengajuan = Pengajuan::where('uuid', $pengajuan_uuid)->first();
      $x['title'] = 'Validasi Berkas';
      return view('pengajuan.verifikasi.QR-verifikasi', $x, compact('pengajuan'));
   }
}
