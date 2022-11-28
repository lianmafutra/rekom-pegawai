<?php

namespace App\Utils;

use Carbon\Carbon;
use File;

class uploadFile
{
   public function save($file, $folder)
   {
      try {
         $name_uniqe =  pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();

         $tahun = Carbon::now()->format('Y');
         $bulan = Carbon::now()->format('m');
         $custom_path = $tahun . '/' . $bulan . '/' . $folder;
         $path = storage_path('app/public/' . $custom_path);

         if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
         }

         $file->storeAs('public/' . $tahun . '/' . $bulan . '/' . $folder, $name_uniqe);

         return collect([
            'nama' => $name_uniqe,
            'path' => $custom_path,
         ]);
         
      } catch (\Throwable $th) {
         return redirect()->back()->with('error', 'Gagal' . $th, 400)->send();
      }
   }
}
