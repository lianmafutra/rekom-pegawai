<?php

namespace App\Http\Services\Surat;

use App\Config\SuratTtd;
use App\Exceptions\CustomException;
use App\Http\Services\Pegawai\PegawaiService;
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
         $path_rekom = 'public/' . $uploadFile->getPath('surat_rekom');
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
         // dd($this->pengajuan->njab);
         // -- generate file word dan parsing data -- //
         $templateProcessor = new TemplateProcessor($path_surat);
         $templateProcessor->setValues([

            'nama'    => htmlspecialchars($this->pengajuan->nama),1, $this->pengajuan->nama,
            'nip'     => htmlspecialchars($this->pengajuan->nip),1, $this->pengajuan->nip,
            'pangkat' => htmlspecialchars($this->pengajuan->pangkat . '(' . $this->pengajuan->ngolru . ')'), 1,
            'jabatan' => htmlspecialchars($this->pengajuan->njab),1,
            'opd'     => htmlspecialchars($this->pengajuan->nunker),1,

            'tgl_cetak'    => 'Lian Mafutra',
            'tgl_kirim'    => 'Lian Mafutra',
            'jenis_rekom'  => htmlspecialchars($this->pengajuan->getRekomJenisNamaAttribute(),), 1,
            'kode_surat'   => htmlspecialchars($this->pengajuan->keperluan->kode_surat),1,
            'no_pengantar' => htmlspecialchars($this->pengajuan->nomor_pengantar),1,
            'perihal'      => htmlspecialchars($this->pengajuan->keperluan->nama),1,

            'nama_ttd'    => htmlspecialchars($user_ttd['nama']),1,
            'jabatan_ttd' => htmlspecialchars($user_ttd['pangkat'] . '/' . $user_ttd['ngolru']), 1,
            'nip_ttd'     => htmlspecialchars($user_ttd['nipbaru'],),1,

         ]);

         $path_doc = Storage::path($path_rekom . '/' . $name_uniqe);
         $templateProcessor->saveAs($path_doc);


         if ($path_doc == null || $path_doc == '') {
            throw new CustomException('Gagal generate Word', 400);
         }

         // -- convert file word to pdf (hasil surat rekom)-- //
         if (config('global.env') == 'dev') {
            exec('cd "C:\Program Files\LibreOffice\program\" && soffice --headless --convert-to pdf ' . $path_doc . ' --outdir ' .  Storage::path($path_rekom), $output, $result_code);
         } elseif (config('global.env') == 'prod') {
            // koding convert production linux
         }

         if (!$result_code) {
            // delete file docx if succes convert
            // Storage::delete($path_rekom . '/' . $name_uniqe);
         } else {
            throw new CustomException('Gagal Convert ke PDF', 400);
         }
         return $this;
      } catch (\Throwable $th) {
         throw $th;
      }
   }
}
