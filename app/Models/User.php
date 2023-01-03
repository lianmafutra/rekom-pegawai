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


   protected $fillable = [
      'username',
      'password',
      //   'name',
      'last_login_at',
      'last_login_ip',
      'opd_id',
   ];

   protected $hidden = [
      'password',
      'remember_token',
   ];

   public function opd()
   {
      return $this->belongsTo(OPD::class);
   }

   public function getWithOpd()
   {
      return $this->with('opd')->where('id', auth()->user()->id)->first()->opd;
   }

   public function getRoleName()
   {
      return auth()->user()->getRoleNames()[0];
   }

   public function file_foto()
   {
      return $this->hasOne(File::class, 'file_id', 'foto');
   }

   public function getUrlFoto()
   {

      $file = User::where('id', auth()->user()->id)->with('file_foto')->first()->file_foto;

      if ($file) {
         return  'http://' . request()->getHttpHost() .
            '/storage/' .
            $file->path .
            '/' .
            $file->name_random;
      }

      return "http://" . request()->getHttpHost() . "/img/avatar.png";
   }

   public function checkPassword($password)
   {
      if (Hash::check($password, auth()->user()->password)) {
         return true;
      } else {
         return false;
      }
   }
}
