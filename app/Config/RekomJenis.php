<?php

namespace App\Config;

use Illuminate\Validation\Rules\Enum;

Enum RekomJenis 
{
    /**
     *@desc jenis rekom pengajuan pelanggaran Hukuman
     */
    const HUKUMAN      = 'Rekomendasi Hukuman Disiplin';

    /**
    *@desc jenis rekom pengajuan pelanggaran Disiplin
    */
  const DISIPLIN     = 'Rekomendasi Bebas Temuan';
  
}
