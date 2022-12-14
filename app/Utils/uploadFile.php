<?php

namespace App\Utils;

use App\Exceptions\CustomException;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class uploadFile
{

   protected $file;
   protected $path;
   protected $uuid;
   protected $parent_id;

   public function file($file)
   {
      $this->file =  $file;
      return $this;
   }

   public function path(string $path)
   {
      $this->path =  $path;
      return $this;
   }

   public function uuid(string $uuid)
   {
      $this->uuid =  $uuid;
      return $this;
   }

   public function parent_id(string $parent_id)
   {
      $this->parent_id =  $parent_id;
      return $this;
   }

   public function save()
   {
      $name_uniqe = null;
      $custom_path = null;
      $uuid = null;
      try {


         if ($this->file) {
            DB::beginTransaction();
            $name_ori = $this->file->getClientOriginalName();
            $name_uniqe =  RemoveSpace::removeDoubleSpace(pathinfo($name_ori, PATHINFO_FILENAME) . '-' . now()->timestamp . '.' . $this->file->getClientOriginalExtension());
            $tahun       = Carbon::now()->format('Y');
            $bulan       = Carbon::now()->format('m');
            $custom_path = $tahun . '/' . $bulan . '/' . $this->path;
            $path        = storage_path('app/public/' . $custom_path);

            if (!FacadesFile::isDirectory($path)) {
               FacadesFile::makeDirectory($path, 0777, true, true);
            }

            File::create([
               'file_id'        => $this->uuid,
               'parent_file_id' => $this->parent_id,
               'name_origin'    => $name_ori,
               'name_random'    => $name_uniqe,
               'path'           => $custom_path,
               'size'           => $this->file->getSize(),
            ]);


            $this->file->storeAs('public/' . $tahun . '/' . $bulan . '/' . $this->path, $name_uniqe);
            DB::commit();
         }
      } catch (\Throwable $th) {
         DB::rollBack();
         throw $th;
      }
   }

   public function update($file_id)
   {
      $name_uniqe = null;
      $custom_path = null;
      $uuid = null;
      try {

         if ($this->file) {
            DB::beginTransaction();
            $name_ori = $this->file->getClientOriginalName();
            $name_uniqe =  RemoveSpace::removeDoubleSpace(pathinfo($name_ori, PATHINFO_FILENAME) . '-' . now()->timestamp . '.' . $this->file->getClientOriginalExtension());
            $tahun       = Carbon::now()->format('Y');
            $bulan       = Carbon::now()->format('m');
            $custom_path = $tahun . '/' . $bulan . '/' . $this->path;
            $path        = storage_path('app/public/' . $custom_path);

            if (!FacadesFile::isDirectory($path)) {
               FacadesFile::makeDirectory($path, 0777, true, true);
            }

           $update = File::where('file_id', $file_id)->update(
                  [
                     'name_origin'    => $name_ori,
                     'name_random'    => $name_uniqe,
                     'path'           => $custom_path,
                     'size'           => $this->file->getSize(),
                  ]
               );
              
              
            $this->file->storeAs('public/' . $tahun . '/' . $bulan . '/' . $this->path, $name_uniqe);
            DB::commit();
           
         }
      } catch (\Throwable $th) {
         DB::rollBack();
         throw $th;
      }
   }
}
