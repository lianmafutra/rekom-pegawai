<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;

class Convert
{
   protected $uploadFile;

   public function __construct(uploadFile $uploadFile)
   {
      $this->uploadFile = $uploadFile;
   }

   public function generateRekomPDF(){
      $path = Storage::path('public/template_surat_rekom.docx');
      $output = Storage::path('public/');
      // $name_ori = $this->file->getClientOriginalName();

      // $name_uniqe =  RemoveSpace::removeDoubleSpace(pathinfo($name_ori, PATHINFO_FILENAME) . '-' . now()->timestamp . '.' . $this->file->getClientOriginalExtension());
      // $tahun       = Carbon::now()->format('Y');
      // $bulan       = Carbon::now()->format('m');
      // $custom_path = $tahun . '/' . $bulan . '/' . $this->path;
      // $path        = storage_path('app/public/' . $custom_path);

      // if (!FacadesFile::isDirectory($path)) {
      //    FacadesFile::makeDirectory($path, 0777, true, true);
      // }

      // File::create([
      //    'file_id'        => $this->uuid,
      //    'parent_file_id' => $this->parent_id,
      //    'name_origin'    => $name_ori,
      //    'name_random'    => $name_uniqe,
      //    'path'           => $custom_path,
      //    'size'           => $this->file->getSize(),
      // ]);

     
      $templateProcessor = new TemplateProcessor($path);
      $templateProcessor->setValue('nama', 'Lian Mafutra2222');
      $output2 = Storage::path('public/barudataku11227799.docx');
      $templateProcessor->saveAs(  $output2);

      exec('cd "C:\Program Files\LibreOffice\program\" && soffice --headless --convert-to pdf ' .  Storage::path('public/barudataku11227799.docx') . ' --outdir ' . $output, $output, $result_code);
      // return $result_code;
   }
}
