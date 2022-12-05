<?php

namespace App\Config;

use Illuminate\Validation\Rules\Enum;

class Role extends Enum
{
   const isAdminOpd         = 'admin_opd';
   const isAdminInspektorat = 'admin_inspektorat';
   const isKasubag          = 'admin_kasubag';
   const isInspektur        = 'inspektur';
   const isSuperadmin       = 'superadmin';

}
