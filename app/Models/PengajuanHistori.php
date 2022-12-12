<?php

namespace App\Models;

use App\Utils\AutoUUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanHistori extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_histori';
    protected $guarded = [];
    use AutoUUID;
   protected $appends = ['tgl_kirim'];

   public function getTglKirimAttribute(){
      return  Carbon::parse($this->created_at)->translatedFormat('d-m-Y H:m:s');
   }
    
    public function pengajuan(){
      return $this->belongsTo(Pengajuan::class);
    }

    public function aksi(){
      return $this->hasOne(PengajuanAksi::class, 'id', 'pengajuan_aksi_id');
    }

    public function user(){
      return $this->hasOne(PengajuanAksi::class, 'penerima_id', 'id');
    }
}
