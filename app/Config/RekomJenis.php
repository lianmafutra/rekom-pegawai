<?php

namespace App\Config;

use Illuminate\Validation\Rules\Enum;

Enum RekomJenis 
{
    /**
     *@desc Rekomendasi Hukuman Disiplin
     */
    const DISIPLIN      = 'DISIPLIN';

    /**
    *@desc Rekomendasi Bebas Temuan
    */
    const TEMUAN     = 'TEMUAN';
  
}
