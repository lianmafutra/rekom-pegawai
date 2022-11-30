<?php

namespace App\Utils;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Str;

class uploadFile
{
   public function save($file, $folder, $saveDB = null)
   {
      $name_uniqe = null;
      $custom_path = null;
      $uuid = null;
      try {
         if ($file) {
            $name_ori = $file->getClientOriginalName();
            $name_uniqe =  pathinfo($name_ori, PATHINFO_FILENAME) . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
            $tahun       = Carbon::now()->format('Y');
            $bulan       = Carbon::now()->format('m');
            $custom_path = $tahun . '/' . $bulan . '/' . $folder;
            $path        = storage_path('app/public/' . $custom_path);
            if (!FacadesFile::isDirectory($path)) {
               FacadesFile::makeDirectory($path, 0777, true, true);
            }
            $uuid = Str::uuid()->toString();
            if ($saveDB) {
               File::create([
                  'file_id'     => $uuid,
                  'name_origin' => $name_ori,
                  'name_random' => $name_uniqe,
                  'path'        => $custom_path,
                  'size'        => $file->getSize(),
               ]);
            }
            $file->storeAs('public/' . $tahun . '/' . $bulan . '/' . $folder, $name_uniqe);
         }
         return collect([
            'nama'    => $name_uniqe,
            'path'    => $custom_path,
            'file_id' => $uuid,
         ]);
      } catch (\Throwable $th) {
        
         return redirect()->back()->with('error', 'Gagal' . $th, 400)->send();
      }
   }
}
