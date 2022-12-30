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
use App\Models\File;
use App\Utils\ApiResponse;
use App\Utils\ShortUrl;
use App\Utils\uploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengajuanService
{

   use ApiResponse;

  

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
            'penerima_id'         => 3, //admin inspektorat
            'penerima_opd_id'     => $this->getPenerimaOpdId(),
            'file_sk_terakhir'    => Str::uuid()->toString(),
            'file_pengantar_opd'  => Str::uuid()->toString(),
            'file_konversi_nip'   => $request->hasFile('file_konversi_nip') ? Str::uuid()->toString() : NULL,
            'catatan'             => $request->catatan,
            
         ]);
         return $pengajuan;
      } catch (\Throwable $th) {
         throw new CustomException("Terjadi Kesalahan saat Menginput Data Pengajuan");
      }
   }

   public function updatePengajuan($pegawai_cache, $request)
   {
      try {

         $data                  = Pengajuan::where('uuid', $request->pengajuan_uuid)->firstOrFail();
         $data->nip             = $pegawai_cache['nipbaru'];
         $data->gldepan         = $pegawai_cache['gldepan'];
         $data->glblk           = $pegawai_cache['glblk'];
         $data->nama            = $pegawai_cache['nama'];
         $data->kunker          = $pegawai_cache['kunker'];
         $data->nunker          = $pegawai_cache['nunker'];
         $data->kjab            = $pegawai_cache['kjab'];
         $data->njab            = $pegawai_cache['njab'];
         $data->keselon         = $pegawai_cache['keselon'];
         $data->neselon         = $pegawai_cache['neselon'];
         $data->kgolru          = $pegawai_cache['kgolru'];
         $data->ngolru          = $pegawai_cache['ngolru'];
         $data->pangkat         = $pegawai_cache['pangkat'];
         $data->photo           = $pegawai_cache['photo'];
         $data->nomor_pengantar = $request->nomor_pengantar;
         $data->rekom_jenis     = $request->rekom_jenis;
         $data->keperluan_id    = $request->keperluan_id;
         $data->pengirim_id     = auth()->user()->id;
         $data->penerima_id     = 3; //admin inspektorat
         $data->penerima_opd_id = $this->getPenerimaOpdId();
         $data->catatan         = $request->catatan;

         if ($data->file_konversi_nip == null) {
            $data->file_konversi_nip = $request->has('file_konversi_nip') ? Str::uuid()->toString() : NULL;
         }
         if (!$request->has('file_konversi_nip')) {
            File:: where('file_id',  $data->file_konversi_nip)->delete();
            $data->file_konversi_nip = NULL;
         }
         $data->save();

         return $data;
      } catch (\Throwable $th) {
         throw $th;
      }
   }

   public function storeHistori($pengajuan_uuid, $aksi_id, $penerima_uuid, $pesan = null)
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
            case PengajuanAksi::VERIFIKASI_DATA:
            case PengajuanAksi::PROSES_SURAT:

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
            default:
               break;
         }
      } catch (\Throwable $th) {
         throw $th;
      }
   }

   public function updateFile($new_file_name, $pengajuan_uuid, $jenis_file)
   {
      $old_file_name = '';
      $pengajuan_cek = Pengajuan::with(['file_sk', 'file_pengantar', 'file_konversi'])
         ->where('uuid', '=', $pengajuan_uuid)->first();
   
      switch ($jenis_file) {
         case 'file_sk':
            $old_file_name = File::where('file_id', '=', $pengajuan_cek->file_sk_terakhir)->first();
            if (  $old_file_name != null ? $old_file_name->rame_random : null != $new_file_name) {
               (new uploadFile())
                   ->file($new_file_name)
                   ->path('pengajuan')
                   ->uuid( $pengajuan_uuid)
                   ->parent_id($pengajuan_cek->id)
                   ->update($pengajuan_cek->file_sk_terakhir);
             }
            break;
         case 'file_pengantar':
            $old_file_name = File::where('file_id', '=', $pengajuan_cek->file_pengantar_opd)->first();
            if (  $old_file_name != null ? $old_file_name->rame_random : null != $new_file_name) {
               (new uploadFile())
                  ->file($new_file_name)
                  ->path('pengajuan')
                  ->uuid( $pengajuan_uuid)
                  ->parent_id($pengajuan_cek->id)
                  ->update($pengajuan_cek->file_pengantar_opd);
            }
            break;
         case 'file_konversi':
            $old_file_name = File::where('file_id', '=', $pengajuan_cek->file_konversi_nip)->first();
            
      if (  $old_file_name != null ? $old_file_name->rame_random : null != $new_file_name) {
         (new uploadFile())
            ->file($new_file_name)
            ->path('pengajuan')
            ->uuid( $pengajuan_uuid)
            ->parent_id($pengajuan_cek->id)
            ->update($pengajuan_cek->file_konversi_nip);
      }
            break;
         default:
            break;
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
         throw new CustomException("Kesalahan Mengupdate Data" . $th);
      }
   }


   /**
    *@desc cek button aksi tiap role dan berdasarkan kondisi pengajuan
    *return pengajuan aksi id
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
    function getLastPengajuanHIstori($pengajuan_uuid)
    {
       $status =  Pengajuan::with('histori')->where('uuid', $pengajuan_uuid);
       return $status->first()->histori->where('pengajuan_aksi_id', '!=', 2)->where('pengajuan_aksi_id', '!=', 5)->last();
    }

       /**
    *@desc update tgl_aksi pengajuan histori untuk hitung notif per user 
    */
    function updateTglAksiPengajuanHistori($pengajuan_uuid)
    {
     $lastPengajuanHistori = $this->getLastPengajuanHIstori($pengajuan_uuid);
     
      PengajuanHistori::where('id', $lastPengajuanHistori->id)->update([
         'tgl_aksi' => Carbon::now()
      ]);
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
            if ($status == PengajuanAksi::SELESAI) $aksi = ['file_rekom'];
            break;
         case  Role::isAdminInspektorat:
            if ($status == PengajuanAksi::MENERUSKAN) $aksi = [];
            elseif ($status == PengajuanAksi::PROSES_SURAT) $aksi = ['tolak', 'selesaikan', 'file_rekom'];
            elseif ($status == PengajuanAksi::TOLAK) $aksi = [];
            elseif ($status == PengajuanAksi::SELESAI) $aksi = ['file_rekom'];
            else $aksi = ['tolak', 'teruskan', 'verifikasi'];
            break;
         case  Role::isKasubag:
            if ($status == PengajuanAksi::VERIFIKASI_DATA) $aksi = ['teruskan'];
            elseif ($status == PengajuanAksi::SELESAI) $aksi = ['file_rekom'];
            break;
         case  Role::isInspektur:
            if ($status == PengajuanAksi::VERIFIKASI_DATA) $aksi = ['setujui'];
            elseif ($status == PengajuanAksi::PROSES_SURAT) $aksi = ['file_rekom'];
            elseif ($status == PengajuanAksi::SELESAI) $aksi = ['file_rekom'];
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
            // $pengajuanService->storeHistori($pengajuan_uuid, PengajuanAksi::VERIFIKASI_DATA);
         }
      } catch (\Throwable $th) {
      }
   }

   
}
