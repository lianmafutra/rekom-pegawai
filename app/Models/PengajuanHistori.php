<?php

namespace App\Models;

use App\Utils\AutoUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanHistori extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_histori';
    protected $guarded = [];
    use AutoUUID;
    
    public function pengajuan(){
      return $this->belongsTo(Pengajuan::class);
    }

    public function aksi(){
      return $this->belongsTo(PengajuanAksi::class);
    }
}
