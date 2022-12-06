<?php

namespace App\Config;

use Illuminate\Validation\Rules\Enum;

class PengajuanAksi extends Enum
{
    /**
     *@desc OPD mengirim pengajuan ke admin inspektorat (admin OPD)
     */
   const KIRIM      = 1;

     /**
     *@desc Admin Inspektorat Memproses Berkas
     */
   const PROSES     = 2;
   
     /**
     *@desc Berkas Ditolak (Admin inspektorat)
     */
   const TOLAK      = 3;
   
     /**
     *@desc Berkas di verifikasi (Admin kasubag, Inspektur)
     */
   const VERIFIKASI = 4;
   
     /**
     *@desc Admin Inspektorat Memproses Berkas (admin inspektorat)
     */
   const SIAPKAN    = 5;
   
     /**
     *@desc Berkas telah selesai (admin inspektorat)
     */
   const SELESAI    = 6;

   
     /**
     *@desc Berkas ditolak oleh admin inspektorat dan dikirim ulang oleh Admin OPD(admin inspektorat)
     */
    const REVISI    = 7;
}
