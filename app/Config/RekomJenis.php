<?php

namespace App\Config;

use Illuminate\Validation\Rules\Enum;

Enum RekomJenis 
{
    /**
     *@desc Rekomendasi Hukuman Disiplin
     */
    const DISIPLIN      = 'Rekomendasi Hukuman Disiplin';

    /**
    *@desc Rekomendasi Bebas Temuan
    */
    const TEMUAN     = 'Rekomendasi Bebas Temuan';
  
}
