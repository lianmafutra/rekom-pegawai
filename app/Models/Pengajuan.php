<?php

namespace App\Models;

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
      return Carbon::parse($this->attributes['tgl_surat_pengantar'])->format('d-m-Y'); 
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
      if( $this->rekom_jenis == 'DISIPLIN'){
         return config('global.rekom_jenis.DISIPLIN');
      }else{
         return config('global.rekom_jenis.TEMUAN');
      }
   }

   public function file_sk()
   {
      return $this->hasMany(File::class, 'file_id', 'file_sk_terakhir');
   }

   public function file_pengantar()
   {
      return $this->hasMany(File::class, 'file_id', 'file_pengantar');
   }

   public function file_konversi()
   {
      return $this->hasMany(File::class, 'file_id', 'file_konversi_nip');
   }

   public function keperluan(){
      return $this->belongsTo(Keperluan::class);
   }

 
}
