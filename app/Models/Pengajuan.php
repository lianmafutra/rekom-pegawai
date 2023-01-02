<?php

namespace App\Models;

use App\Config\PengajuanKirim;
use App\Config\Role;
use App\Utils\AutoUUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
   use HasFactory;
   use AutoUUID;
   protected $table = 'pengajuan';
   protected $guarded = [];
   protected $appends = ['tgl_kirim', 'file_url', 'rekom_jenis_nama'];

   public function getTglKirimAttribute()
   {
      return  Carbon::parse($this->created_at)->translatedFormat('d-m-Y H:m:s');
   }

   public function getTglSuratPengantarAttribute()
   {
      return Carbon::parse($this->attributes['tgl_surat_pengantar'])->format('d/m/Y');
   }

   public function setTglSuratPengantarAttribute($tgl_surat_pengantar)
   {
      $this->attributes['tgl_surat_pengantar'] = Carbon::createFromFormat('d-m-Y', $tgl_surat_pengantar)->format('Y-m-d');
   }

   public function getFileUrlAttribute()
   {
      return url('storage/profile/' . $this->foto);
   }


   public function getRekomJenisNamaAttribute()
   {
      if ($this->rekom_jenis == 'DISIPLIN') {
         return config('global.rekom_jenis.DISIPLIN');
      } else {
         return config('global.rekom_jenis.TEMUAN');
      }
   }

   public function file_sk()
   {
      return $this->hasMany(File::class, 'file_id', 'file_sk_terakhir');
   }

   public function file_pengantar()
   {
      return $this->hasMany(File::class, 'file_id', 'file_pengantar_opd');
   }

   public function file_konversi()
   {
      return $this->hasMany(File::class, 'file_id', 'file_konversi_nip');
   }

   public function file_rekom()
   {
      return $this->hasOne(File::class, 'file_id', 'file_rekom_hasil');
   }


   public function getFileRekomHasil()
   {

      $file = $this->with('file_rekom')->first()->file_rekom;
      if ($file) {
         return  'http://' . request()->getHttpHost() .
            '/storage/' .
            $file->path .
            '/' .
            $file->name_random;
      }
   }

   public function keperluan()
   {
      return $this->belongsTo(Keperluan::class);
   }


   public function pengirim()
   {
      return $this->belongsTo(User::class, 'pengirim_id', 'id');
   }

   public function histori()
   {
      return $this->hasMany(PengajuanHistori::class);
   }

   public function getPengajuanWithData($pengajuan_uuid)
   {
      return Pengajuan::with(['keperluan', 'file_sk', 'file_pengantar', 'file_konversi', 'file_rekom'])->where('uuid', $pengajuan_uuid)->first();
   }

   



   /**
    *@desc cek akses user tujuan teruskan pengajuan 
    */
   public function getUserKirim()
   {
      $user = auth()->user()->getRoleNames()[0];
      if ($user == Role::isAdminOpd) {
         return User::where('id', PengajuanKirim::ADMIN_INSPEKTORAT)->get();
      }
      if ($user == Role::isAdminInspektorat) {
         return User::where('id', PengajuanKirim::ADMIN_KASUBAG)->get();
      }
      if ($user == Role::isKasubag) {
         return User::where('id', PengajuanKirim::INSPEKTUR)->get();
      }
      if ($user == Role::isInspektur) {
         return User::where('id', PengajuanKirim::ADMIN_INSPEKTORAT)->get();
      }
   }
}
