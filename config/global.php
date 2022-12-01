<?php
return [
   
   // URL API BKD
   'url' =>[
      'bkd' => [
         'pegawai' => 'https://presensi.jambikota.go.id/api/Absen?ABSEN-API-KEY=kominfo',
         'foto'    => 'https://bkd.jambikota.go.id/simpeg/photo/'
      ]
   ],
   // Rekom Jenis Pengajuan 
   'rekom_jenis'=>[
      'DISIPLIN' => 'Bebas Hukuman Disiplin',
      'TEMUAN'   => 'Bebas Temuan'
   ],


  
   // ROLE USER
   'role'=> [
      'is_superadmin'        => 'superadmin',
      'is_admin_inspektorat' => 'admin_inspektorat',
      'is_admin_opd'         => 'admin_opd',
      'is_admin_kasubag'     => 'admin_kasubag',
      'is_inspektur'         => 'inspektur'
   ]
    
];
