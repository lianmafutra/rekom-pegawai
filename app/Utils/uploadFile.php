<?php

namespace App\Utils;

class uploadFile
{
   public function save($file, $folder){
      try {
         $name_uniqe =  pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME). '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
         $file->storeAs('public/'.$folder, $name_uniqe);
      } catch (\Throwable $th) {
         return redirect()->back()->with('error', 'Gagal'.$th, 400)->send();
      }
     
   }
}
