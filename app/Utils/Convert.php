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
    
      $templateProcessor = new TemplateProcessor($path);
      $templateProcessor->setValue('nama', 'Lian Mafutra2222');
      $output2 = Storage::path('public/barudataku11227799.docx');
      $templateProcessor->saveAs($output2);

      exec('cd "C:\Program Files\LibreOffice\program\" && soffice --headless --convert-to pdf ' .  Storage::path('public/barudataku11227799.docx') . ' --outdir ' . $output, $output, $result_code);
      // return $result_code;
   }
}
