<?php

namespace App\Http\Services\Pegawai;

use App\Config\Pengajuan as ConfigPengajuan;
use Carbon\Carbon;
use App\Config\Role;
use App\Models\User;
use App\Models\Pengajuan;
use Illuminate\Support\Str;
use App\Config\PengajuanAksi;
use App\Models\PengajuanHistori;
use App\Exceptions\CustomException;
use App\Utils\ApiResponse;
use Illuminate\Support\Facades\Auth;


class PengajuanService
{

   use ApiResponse;

   public function getPenerimaId()
   {

      if (Auth::user()->hasRole(Role::isAdminOpd)) {
         return 6;
      }
      if (Auth::user()->hasRole(Role::isAdminInspektorat)) {
         return 4;
      }
      if (Auth::user()->hasRole(Role::isKasubag)) {
         return 5;
      }
      if (Auth::user()->hasRole(Role::isInspektur)) {
         return 6;
      }
   }

   public function getPenerimaOpdId()
   {
      // default inspektorat OPD
      return 36;
   }

   public function storePengajuan($pegawai_cache, $request)
   {

      try {
         $pengajuan = Pengajuan::create([
            'nip'                 => $pegawai_cache['nipbaru'],
            'gldepan'             => $pegawai_cache['gldepan'],
            'glblk'               => $pegawai_cache['glblk'],
            'nama'                => $pegawai_cache['nama'],
            'kunker'              => $pegawai_cache['kunker'],
            'nunker'              => $pegawai_cache['nunker'],
            'kjab'                => $pegawai_cache['kjab'],
            'njab'                => $pegawai_cache['njab'],
            'keselon'             => $pegawai_cache['keselon'],
            'neselon'             => $pegawai_cache['neselon'],
            'kgolru'              => $pegawai_cache['kgolru'],
            'ngolru'              => $pegawai_cache['ngolru'],
            'pangkat'             => $pegawai_cache['pangkat'],
            'photo'               => $pegawai_cache['photo'],
            'nomor_pengantar'     => $request->nomor_pengantar,
            'tgl_surat_pengantar' => $request->tgl_pengantar,
            'rekom_jenis'         => $request->rekom_jenis,
            'keperluan_id'        => $request->keperluan_id,
            'pengirim_id'         => auth()->user()->id,
            'penerima_id'         => $this->getPenerimaId(),
            'penerima_opd_id'     => $this->getPenerimaOpdId(),
            'file_sk_terakhir'    => Str::uuid()->toString(),
            'file_pengantar_opd'      => Str::uuid()->toString(),
            'file_konversi_nip'   => Str::uuid()->toString(),
            'catatan'             => $request->catatan,
         ]);
         return $pengajuan;
      } catch (\Throwable $th) {
         throw new CustomException("Terjadi Kesalahan saat Menginput Data Pengajuan");
      }
   }

   public function storeHistori($pengajuan_uuid, $aksi_id, $penerima_uuid = null, $pesan = null)
   {
      try {

         $pengirim     = User::with('opd')->find(auth()->user()->id);

         $pengajuan_id = Pengajuan::where('uuid', $pengajuan_uuid)->first()->id;

         switch ($aksi_id) {

            case PengajuanAksi::KIRIM_BERKAS:
            case PengajuanAksi::MENERUSKAN:
            case PengajuanAksi::REVISI:
            case PengajuanAksi::TOLAK:
            case PengajuanAksi::SELESAI:
               $penerima     = User::with('opd')->where('uuid', $penerima_uuid)->first();
               PengajuanHistori::create([
                  'pengajuan_id'      => $pengajuan_id,
                  'penerima_id'       => $penerima->id,
                  'pengirim_id'       => $pengirim->id,
                  'penerima_nama'     => $penerima->name,
                  'pengirim_nama'     => $pengirim->name,
                  'opd_pengirim'      => $pengirim->opd->nunker,
                  'opd_penerima'      => $penerima->opd->nunker,
                  'pengajuan_aksi_id' => $aksi_id,
                  'pesan'             => $pesan,
                  'tgl_kirim'         => Carbon::now(),
                  'tgl_proses'        => Carbon::now(),
               ]);
               break;
            case PengajuanAksi::VERIFIKASI_DATA:
               PengajuanHistori::create([
                  'pengajuan_id'      => $pengajuan_id,
                  'penerima_id'       => null,
                  'pengirim_id'       => $pengirim->id,
                  'pengirim_nama'     => $pengirim->name,
                  'opd_pengirim'      => $pengirim->opd->nunker,
                  'pengajuan_aksi_id' => $aksi_id,
                  'pesan'             => $pesan,
                  'tgl_kirim'         => Carbon::now(),
                  'tgl_proses'        => Carbon::now(),
               ]);
            default:

               break;
         }
      } catch (\Throwable $th) {
         throw new CustomException("Terjadi Kesalahan saat Menginput Data Histori" . $th);
      }
   }

   /**
    *@desc update DB 'tgl_proses' pengajuan setiap proses disposisi ,berguna untuk tracking pengajuan yang belum di respon oleh user penerima
    */
   public function updateTglProses($pengajuan_id)
   {
      try {
         PengajuanHistori::where('pengajuan_id', $pengajuan_id)
            ->where('penerima_id', auth()->user()->id)
            ->where('tgl_proses', NULL)
            ->where('user_id', auth()->user()->id)
            ->update([
               'tgl_proses' => Carbon::now()
            ]);
      } catch (\Throwable $th) {
         throw new CustomException("Kesalahan Mengupdate Data" .$th);
      }
   }


   /**
    *@desc cek button aksi tiap role dan berdasarkan kondisi pengajuan
    */
   function cekPengajuanStatus($pengajuan_uuid)
   {
      $status =  Pengajuan::with('histori')->whereHas('histori', function ($q) {
         $q->latest('id');
      })->where('uuid', $pengajuan_uuid);
      return $status->first()->histori->last()->pengajuan_aksi_id;
   }


   /**
    *@desc cek button aksi tiap role dan berdasarkan kondisi pengajuan
    */
   function getViewAksiDetail($pengajuan_uuid)
   {
      $user = new User();
      $aksi = [];
      $status = $this->cekPengajuanStatus($pengajuan_uuid);

      switch ($user->getRoleName()) {

         case  Role::isAdminOpd:
            $aksi = [];
            break;
         case  Role::isAdminInspektorat:
            if ($status == PengajuanAksi::MENERUSKAN) $aksi = [];
            elseif ($status == PengajuanAksi::PROSES_SURAT) $aksi = ['tolak', 'selesaikan', 'file_rekom'];
            elseif ($status == PengajuanAksi::TOLAK) $aksi = [];
            elseif ($status == PengajuanAksi::SELESAI) $aksi = ['file_rekom'];
            else $aksi = ['tolak', 'teruskan', 'verifikasi'];
            break;
         case  Role::isKasubag:
            $aksi = ['teruskan'];
            break;
         case  Role::isInspektur:
            $aksi = ['teruskan'];
            break;
         default:
            $aksi = [];
            break;
      }

      return view('pengajuan.detail-action', compact(['aksi']))->render();
   }

   /**
    *@desc cek histori sudah dilihat (proses) oleh admin inspektorat atau belum jika belum ada insert histori jika ada abaikan
    */
   function cekHistoriProsesAdminOpd($pengajuan_uuid)
   {

      try {
         $user = new User();
         $pengajuanService = new PengajuanService();

         $histori  = Pengajuan::with(['histori'])
            ->whereRelation('histori', 'pengajuan_aksi_id', '=', PengajuanAksi::VERIFIKASI_DATA)
            ->where('uuid', '=', $pengajuan_uuid)
            ->first();


         // jika belum ada maka insert histori pengajuan dengan status proses
         if ($histori == null && $user->getRoleName() == Role::isAdminInspektorat) {
            $pengajuanService->storeHistori($pengajuan_uuid, PengajuanAksi::VERIFIKASI_DATA);
         }
      } catch (\Throwable $th) {
      }
   }

   function generateFileRekom()
   {
      // data user
      // jenis rekom 
      // jenis keperluan
      //file TTD
      // file barcode
   }
}
