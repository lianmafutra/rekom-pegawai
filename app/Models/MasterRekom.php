<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRekom extends Model
{
    use HasFactory;
    protected $table = 'master_rekom';
    protected $guarded = []; 
   protected $appends = ['tgl_input', 'rekom_jenis_nama'];


    public function getTglInputAttribute()
    {
       return Carbon::parse($this->attributes['created_at'])->format('d-m-Y H:m');
    }


    public function opd()
    {
        return $this->hasOne(OPD::class, 'kunker', 'kunker');
    }

    public function getRekomJenisNamaAttribute()
    {
       if ($this->rekom_jenis == 'DISIPLIN') {
          return config('global.rekom_jenis.DISIPLIN');
       } 
       if ($this->rekom_jenis == 'TEMUAN') {
          return config('global.rekom_jenis.TEMUAN');
       }
    }
 
 
}
