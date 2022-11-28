<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function opd() { 
      return $this->belongsTo(OPD::class);
    }

    public function getWithOpd(){
      return $this->with('opd')->where('id', auth()->user()->id)->first()->opd;
    }
  
   protected $appends = ['foto_url'];

   public function getFotoUrlAttribute()
   {
      if($this->foto){
         return url('storage/profile/' . $this->foto);
      }else{
            return "http://".request()->getHttpHost()."/img/avatar.png";
      }

   }

 
}
