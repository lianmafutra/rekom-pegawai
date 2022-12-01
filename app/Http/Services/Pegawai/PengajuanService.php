<?php

namespace App\Http\Services\Pegawai;

use App\Config\Role;
use Illuminate\Support\Facades\Auth;

class PengajuanService
{
   public function getPenerimaId(){
    
      if(Auth::user()->hasRole(Role::isAdminOpd)){
         return 6;
       }
      if(Auth::user()->hasRole(Role::isAdminInspektorat)){
        return 4;

      } if(Auth::user()->hasRole(Role::isKasubag)){
         return 5;

      } if(Auth::user()->hasRole(Role::isInspektur)){
        return 6;
      } 
   }

   public function getPenerimaOpdId(){
      // default inspektorat OPD
       return 36; 
   }

}