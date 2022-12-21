<?php

namespace App\Http\Services\Surat;

use App\Config\SuratTtd;
use App\Exceptions\CustomException;
use App\Utils\RemoveSpace;
use App\Utils\uploadFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use NcJoes\OfficeConverter\OfficeConverter;

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
         $name_uniqe =  RemoveSpace::removeDoubleSpace(pathinfo('surat-rekom', PATHINFO_FILENAME) . '-' . now()->timestamp . '.' . 'docx');
         $path_rekom = 'public/' . $uploadFile->getPath('surat_rekom');

         // --------- get path template docx sesuai jenis TTD surat rekom  --------- //
         switch ($this->ttd) {
            case SuratTtd::TTD_MANUAL:
               $path_surat = Storage::path('public/template/surat_rekom_manual.docx');
               break;
            case SuratTtd::TTD_DIGITAL:
               $path_surat = Storage::path('public/template/surat_rekom_digital.docx');
               break;
         }

         // -- generate file word dan parsing data -- //
         $templateProcessor = new TemplateProcessor($path_surat);
         $templateProcessor->setValues([
            'nama' => 'Lian Mafutra',
         ]);
         $path_doc = Storage::path($path_rekom . '/' . $name_uniqe);
         $templateProcessor->saveAs($path_doc);

         // -- convert file word to pdf (hasil surat rekom)-- //
         if (config('global.env') == 'dev') {
            exec('cd "C:\Program Files\LibreOffice\program\" && soffice --headless --convert-to pdf ' . $path_doc . ' --outdir ' .  Storage::path($path_rekom), $output, $result_code);
         } elseif (config('global.env') == 'prod') {
            // koding convert production linux
         }

         if (!$result_code) {
            // delete file docx if succes convert
            Storage::delete($path_rekom . '/' . $name_uniqe);
        
         } else {
            throw new CustomException('Gagal Convert ke PDF', 400);
         }
         return $this;
      } catch (\Throwable $th) {
         throw $th;
      }
   }
}
