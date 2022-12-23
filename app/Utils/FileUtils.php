<?php
namespace App\Utils;

use Illuminate\Support\Facades\Storage;

class FileUtils
{

   protected $temp_object;

   public function setObjectFile($temp_object){
      $this->$temp_object = $temp_object;
      return $this;
   }

      public function getTempPath(){
         
         $value = current((array) $this->temp_object);
         return $value->filename;
      }

      public function renameFile($path, $new_name, $extension ){
         $temp_data = current((array) $this->temp_object);
         $temp_path =  pathinfo($temp_data->filename);
         $filename = $temp_path['filename'];
         rename(Storage::path($path . '/' . $filename. '.'.$extension), Storage::path($path . '/' . $new_name. '.'.$extension));
      }
}
