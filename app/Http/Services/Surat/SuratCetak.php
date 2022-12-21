<?php

namespace App\Http\Services\Surat;

use App\Config\SuratTtd;
use App\Utils\RemoveSpace;
use App\Utils\uploadFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class SuratCetak
{


   protected $rekomJenis;
   protected $pengajuan;
   protected $ttd;
   protected $surat;

  
   public function pengajuan(string $pengajuan)
   {
      $this->pengajuan = $pengajuan;
      return $this;
   }

   public function surat($no, $surat, $lampiran, $hal, $tanggal)
   {
      return $this;
   }

   public function rekomJenis(string $rekomJenis)
   {
      $this->rekomJenis = $rekomJenis;
      return $this;
   }

   public function ttd(string $ttd)
   {
      $this->ttd = $ttd;
      return $this;
   }

   public function cetak()
   {

      $uploadFile = new uploadFile();
      try {
         $path_surat = '';
         $name_uniqe =  RemoveSpace::removeDoubleSpace(pathinfo('surat-rekom', PATHINFO_FILENAME) . '-' . now()->timestamp . '.' .'docx');

         switch ($this->ttd) {
            case SuratTtd::TTD_MANUAL:
               $path_surat = Storage::path('public/template/surat_rekom_manual.docx');
               break;
            case SuratTtd::TTD_DIGITAL:
               $path_surat = Storage::path('public/template/surat_rekom_digital.docx');
               break;
         }

         $path_rekom = 'public/'.$uploadFile->getPath('surat_rekom');
   
         // generate word file
         $templateProcessor = new TemplateProcessor($path_surat);
         $templateProcessor->setValue('nama', 'Lian Mafutra 12345');

         $path_doc = Storage::path($path_rekom.'/'.$name_uniqe);
         $templateProcessor->saveAs($path_doc);
   
         // convert word to pdf
         if(config('global.env') == 'dev'){
            // exec('cd "C:\Program Files\LibreOffice\program\" && soffice --headless --convert-to pdf ' .  $path_rekom.'/barudataku11227799.docx' . ' --outdir ' . $path_rekom, $output, $result_code);
         }

         // delete file docx if succes convert


     
      } catch (\Throwable $th) {
         throw $th;
      }
      
   }
}
