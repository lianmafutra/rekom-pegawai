<?php

namespace App\Models;

use App\Utils\ApiResponse;
use App\Utils\AutoUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\ResponseTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use AutoUUID;
    use ApiResponse;

    protected $appends = ['foto_url'];

    protected $fillable = [
        'username',
        'password',
        'opd_id',
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

    public function getRoleName(){
      return auth()->user()->getRoleNames()[0];
    }

   public function getFotoUrlAttribute()
   {
      if($this->foto){
         return "http://".request()->getHttpHost(). "/storage/". $this->foto_path."/".$this->foto;
       
      }else{
            return "http://".request()->getHttpHost()."/img/avatar.png";
      }
   }

   public function checkPassword($password){
      if(Hash::check($password, auth()->user()->password)) {
         return true;
     } else {
         return false;
     }
   }

 
}
