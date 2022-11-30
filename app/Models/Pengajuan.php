<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;
    protected $table = 'pengajuan';
    protected $guarded = []; 
    protected $appends = ['tgl_kirim', 'file_url'];

    public function getTglKirimAttribute() {
      return  Carbon::parse( $this->created_at)->translatedFormat('d-m-Y H:m:s');
   }

   public function getFileUrlAttribute() {
      return url('storage/profile/'.$this->foto);
 }

 public function file() { 
   return $this->hasMany(File::class);
 }
 
}
