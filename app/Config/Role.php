<?php

namespace App\Config;

use Illuminate\Validation\Rules\Enum;

class Role extends Enum
{
   const isAdminOpd         = 'adminopd';
   const isAdminInspektorat = 'admininspektorat';
   const isKasubag          = 'adminkasubag';
   const isInspektur        = 'inspektur';
   const isSuperadmin       = 'superadmin';

}
