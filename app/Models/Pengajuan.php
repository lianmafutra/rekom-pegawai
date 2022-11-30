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
   protected $appends = ['tgl_kirim', 'file_url'];

   public function getTglKirimAttribute()
   {
      return  Carbon::parse($this->created_at)->translatedFormat('d-m-Y H:m:s');
   }

   public function setTglSuratPengantarAttribute($tgl_surat_pengantar)
   {
      $this->attributes['tgl_surat_pengantar'] = Carbon::createFromFormat('d-m-Y', $tgl_surat_pengantar)->format('Y-m-d');
   }


   public function getFileUrlAttribute()
   {
      return url('storage/profile/' . $this->foto);
   }

   public function file()
   {
      return $this->hasMany(File::class);
   }
}
