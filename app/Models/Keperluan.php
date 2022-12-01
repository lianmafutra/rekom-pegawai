<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keperluan extends Model
{
    use HasFactory;
    protected $table = 'keperluan';
    protected $guarded = []; 

    public function pengajuan(){
      return $this->hasMany(Pengajuan::class);
   }
}
