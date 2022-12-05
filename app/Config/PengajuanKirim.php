<?php

namespace App\Config;

use Illuminate\Validation\Rules\Enum;

class PengajuanKirim extends Enum
{
   const SUPERADMIN        = 1;
   const ADMIN_OPD         = 2;
   const ADMIN_INSPEKTORAT = 3;
   const ADMIN_KASUBAG     = 5;
   const INSPEKTUR         = 4;
   

}
