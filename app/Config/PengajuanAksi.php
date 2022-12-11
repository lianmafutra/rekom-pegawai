<?php

namespace App\Config;

use Illuminate\Validation\Rules\Enum;

class PengajuanAksi extends Enum
{

   const KIRIM_BERKAS       = 1;
   const VERIFIKASI_DATA    = 2;
   const VERIFIKASI_HUKUMAN = 3;
   const MENERUSKAN         = 4;
   const PROSES_SURAT       = 5;
   const SELESAI            = 6;
   const REVISI             = 7;
   const TOLAK              = 8; 
}
