<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanAksi extends Model
{
   use HasFactory;
   protected $table = 'pengajuan_aksi';
   protected $guarded = [];
   
   public function histori(){
     return $this->hasMany(PengajuanHistori::class);
   }
  
}
