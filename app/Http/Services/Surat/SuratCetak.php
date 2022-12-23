<?php

namespace App\Http\Services\Surat;

use App\Config\SuratTtd;
use App\Exceptions\CustomException;
use App\Http\Services\Pegawai\PegawaiService;
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


   public function pengajuan($pengajuan)
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
         $path_rekom = 'public/' . $uploadFile->getPath('surat_rekom').'/';
         $user_ttd = (new PegawaiService())->filterByNIP(auth()->user()->nip)[0];
        
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
            // Data Pemohon
            'nama'    => $this->clean_word($this->pengajuan->nama . ', ' . $this->pengajuan->glblk),
            'nip'     => $this->clean_word($this->pengajuan->nip),
            'pangkat' => $this->pengajuan->pangkat . ' (' . $this->pengajuan->ngolru . ')',
            'jabatan' => $this->clean_word($this->pengajuan->njab),
            'opd'     => $this->clean_word($this->pengajuan->nunker),
            // Data Surat
            'tgl_cetak'     => 'Lian Mafutra',
            'tgl_pengantar' => $this->clean_word($this->pengajuan->tgl_surat_pengantar),
            'jenis_rekom'   => $this->clean_word($this->pengajuan->getRekomJenisNamaAttribute()),
            'kode_surat'    => $this->clean_word($this->pengajuan->keperluan->kode_surat),
            'no_pengantar'  => $this->clean_word($this->pengajuan->nomor_pengantar),
            'perihal'       => $this->clean_word($this->pengajuan->keperluan->nama),
            // pegawai ttd
            'nama_ttd'    => htmlspecialchars($user_ttd['nama'] . ', ' . $user_ttd['glblk']),
            'jabatan_ttd' => $user_ttd['pangkat'] . '/' . $user_ttd['ngolru'],
            'nip_ttd'     => $this->clean_word($user_ttd['nipbaru']),
         ]);
       
         $templateProcessor->setImageValue('qrcode', array('path' => '', 'width' => 100, 'height' => 100, 'ratio' => false));
         $templateProcessor->setImageValue('img_ttd', array('path' => Storage::path('public/template/ttd_inspektur.png'), 'width' => 100, 'height' => 100, 'ratio' => false));
        
         $file_path_temp = $templateProcessor->save("php://output");
         $filename_temp = pathinfo($file_path_temp)['filename'];
      
         if ($filename_temp == null || $filename_temp == '' || $filename_temp == []) {
            throw new CustomException('Gagal generate file Word', 400);
         }

   

         // -- convert file word to pdf (hasil surat rekom)-- //
         if (config('global.env') == 'dev') {
            exec('cd "C:\Program Files\LibreOffice\program\" && soffice --headless --convert-to pdf ' . $file_path_temp . ' --outdir ' .  Storage::path($path_rekom), $output, $result_code);
         } elseif (config('global.env') == 'prod') {
            // koding convert production linux
         }

         if (!$result_code) {
            rename(Storage::path($path_rekom . $filename_temp.'.pdf'), Storage::path($path_rekom . $name_uniqe. '.pdf'));
         } else {
            throw new CustomException('Gagal Convert ke PDF', 400);
         }
         return $this;
      } catch (\Throwable $th) {
         throw $th;
      }
   }

   private function clean_word($string)
   {
      return htmlspecialchars(ucwords(strtolower($string)));
   }
}
