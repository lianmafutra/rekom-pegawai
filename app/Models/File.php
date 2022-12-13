<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $table = 'file';
    protected $guarded = []; 
    protected $append = ['file_url'];

    public function opd() { 
      return $this->belongsTo(Pengajuan::class);
    }

    public function getFileUrlAttribute()
    {
       return url('storage/' . $this->path . '/'.$this->name_random);
    }
 

}
