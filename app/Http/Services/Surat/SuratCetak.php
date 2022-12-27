<?php

namespace App\Http\Services\Surat;

use App\Config\SuratTtd;
use App\Exceptions\CustomException;
use App\Http\Services\Pegawai\PegawaiService;
use App\Models\File;
use App\Models\Pengajuan;
use App\Utils\RemoveSpace;
use App\Utils\ShortUrl;
use App\Utils\TempFile;
use App\Utils\uploadFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;

class SuratCetak
{


   protected $rekomJenis;
   protected $pengajuan;
   protected $ttd;
   protected $surat;
   protected $uploadFile;
   protected $path_rekom;
   protected $custom_path;
   protected $name_uniq;


   public function __construct()
   {
      $this->uploadFile = new uploadFile();
      $this->custom_path = $this->uploadFile->getPath('surat_rekom');
      $this->path_rekom = 'public/' . $this->custom_path . '/';
      $this->name_uniq =  RemoveSpace::removeDoubleSpace(pathinfo('surat-rekom', PATHINFO_FILENAME) . '-' . now()->timestamp);
   }

   public function setPengajuan($pengajuan)
   {
      $this->pengajuan = $pengajuan;
      return $this;
   }

   public function setRekomJenis(string $rekomJenis)
   {
      $this->rekomJenis = $rekomJenis;
      return $this;
   }

   public function setTTD(string $ttd)
   {
      $this->ttd = $ttd;
      return $this;
   }

   private function clean_word($string)
   {
      return htmlspecialchars(ucwords(strtolower($string)));
   }

   public function cetaksurat()
   {

      try {
         $path_surat = '';

         $pengajuan = Pengajuan::where('uuid', $this->pengajuan->uuid);
         $pengajuan->update([
               'short_url' =>(new ShortUrl())->generate($pengajuan->first()->id),
         ]);
   

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
            'nama'    =>  htmlspecialchars($this->pengajuan->nama . ', ' . $this->pengajuan->glblk),
            'nip'     => $this->clean_word($this->pengajuan->nip),
            'pangkat' => $this->pengajuan->pangkat . ' (' . $this->pengajuan->ngolru . ')',
            'jabatan' => $this->clean_word($this->pengajuan->njab),
            'opd'     => $this->clean_word($this->pengajuan->nunker),
            // Data Surat
            'tgl_cetak'     => Carbon::now()->translatedFormat('F Y'),
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

         $url    = urlencode(route('pengajuan.aksi.link',  $pengajuan->first()->short_url));
         $image  = 'http://chart.apis.google.com/chart?chs=' . 150 . 'x' . 150 . '&cht=qr&chl=' . $url;
         $file = file_get_contents($image);

         $file = new TempFile($file);

         $templateProcessor->setImageValue('qrcode', array('path' =>  $file->getFileName(), 'width' => 150, 'height' => 150, 'ratio' => false));
         $templateProcessor->setImageValue('img_ttd', array('path' => Storage::path('public/template/ttd_inspektur.png'), 'width' => 100, 'height' => 100, 'ratio' => false));

         $file_path_temp = $templateProcessor->save("php://output");
         
         $filename_temp = pathinfo($file_path_temp)['filename'];

         if ($filename_temp == null || $filename_temp == '' || $filename_temp == []) {
            throw new CustomException('Gagal generate file Word', 400);
         }

         // -- convert file word to pdf (hasil surat rekom)-- //
         if (config('global.env') == 'dev') {
            exec('cd "C:\Program Files\LibreOffice\program\" && soffice --headless --convert-to pdf ' .    $file_path_temp . ' --outdir ' .  Storage::path($this->path_rekom), $output, $result_code);
         } elseif (config('global.env') == 'prod') {
            // koding convert production linux
         }

         if (!$result_code) {
            unlink(sys_get_temp_dir() . '/' . $filename_temp . '.tmp');
            rename(Storage::path($this->path_rekom . $filename_temp . '.pdf'), Storage::path($this->path_rekom . $this->name_uniq . '.pdf'));
         } else {
            throw new CustomException('Gagal Convert ke PDF', 400);
         }
         return $this;
      } catch (\Throwable $th) {
         throw $th;
      }
   }

   public function updatefileRekom()
   {

      // update tabel pengajuan kolom file_rekom_hasil dan insert ke tabel file 
      $pengajuan = Pengajuan::where('uuid', $this->pengajuan->uuid);

      $uuid = Str::uuid()->toString();

      if ($pengajuan->first()->file_rekom_hasil == null) {

         $pengajuan->update([
            'file_rekom_hasil' => $uuid,
         ]);

         File::create([
            'file_id'        => $uuid,
            'parent_file_id' => $pengajuan->first()->id,
            'name_origin'    => $this->name_uniq . '.pdf',
            'name_random'    => $this->name_uniq . '.pdf',
            'path'           => $this->custom_path,
         ]);
      } else {
         File::where('file_id', $pengajuan->first()->file_rekom_hasil)
            ->update(
               [
                  'name_origin'    => $this->name_uniq,
                  'name_random'    => $this->name_uniq . '.pdf',
                  'path'           => $this->custom_path,
               ]
            );
      }

      return $this;
   }
}
