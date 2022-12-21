<?php
return [
   
   // URL API BKD
   'url' =>[
      'bkd' => [
         'pegawai' => 'https://presensi.jambikota.go.id/api/Absen?ABSEN-API-KEY=kominfo',
         'foto'    => 'https://bkd.jambikota.go.id/simpeg/photo/'
      ]
   ],

   'env'                 => env('ENV', ''),

   'rekom_jenis'=>[
      'DISIPLIN' => 'Bebas Hukuman Disiplin',
      'TEMUAN'   => 'Bebas Temuan'
   ],

   'status' =>[
      'KIRIM'      => 1,
      'PROSES'     => 2,
      'TOLAK'      => 3,
      'VERIFIKASI' => 4,
      'SIAPKAN'    => 5,
      'SELESAI'    => 6,
      'REVISI'     => 7,
   ],

   // ROLE USER
   'role'=> [
      'is_superadmin'        => 'superadmin',
      'is_admin_inspektorat' => 'admin_inspektorat',
      'is_admin_opd'         => 'admin_opd',
      'is_admin_kasubag'     => 'admin_kasubag',
      'is_inspektur'         => 'inspektur'
   ],

 
];
