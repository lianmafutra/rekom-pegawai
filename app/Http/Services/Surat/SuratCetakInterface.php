<?php

namespace App\Http\Services\Surat;

use App\Models\User;

interface SuratCetakInterface
{
   public function penerima(User $penerima);
   public function pengirim(User $pengirim);
   public function surat($no, $surat, $lampiran, $hal, $tanggal);
   public function rekomJenis(string $rekomJenis);
   public function ttd(string $ttd);
   public function cetak();

}
