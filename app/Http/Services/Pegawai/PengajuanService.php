<?php

namespace App\Http\Services\Pegawai;

use App\Config\Role;
use App\Exceptions\CustomException;
use App\Models\Pengajuan;
use App\Models\PengajuanHistori;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class PengajuanService
{
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

   public function storeHistori($pengajuan_uuid, $aksi_id, $penerima_uuid, $pesan = null)
   {
      try {
         $user = User::with('opd')->find(auth()->user()->id);

         $penerima_id = User::where('uuid', $penerima_uuid)->first()->id;
         $pengajuan_uuid = Pengajuan::where('uuid', $pengajuan_uuid)->first();

         PengajuanHistori::create([
            'pengajuan_uuid'    => $pengajuan_uuid->id,
            'user_id'           => $user->id,
            'user_nama'         => $user->name,
            'penerima_id'       => $penerima_id,
            'opd'               => $user->opd->nunker,
            'pengajuan_aksi_id' => $aksi_id,
            'pesan'             => $pesan,
            'tgl_kirim'         => Carbon::now(),
         ]);
      } catch (\Throwable $th) {
         throw new CustomException("Terjadi Kesalahan saat Menginput Data Histori" + $th);
      }
   }
}
