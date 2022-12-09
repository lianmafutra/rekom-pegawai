<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanOPDStoreRequest extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
   public function authorize()
   {
      return true;
   }

   /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
   public function rules()
   {

      return [
         'pegawai'            => 'required',
         'nomor_pengantar'    => 'required',
         'tgl_pengantar'      => 'required',
         'rekom_jenis'        => 'required',
         'keperluan_id'       => 'required',
         'file_sk'            => 'required|mimes:pdf',
         'file_pengantar_opd' => 'required|mimes:pdf',
         'file_konversi_nip'  => 'mimes:pdf',
      ];
   }

   public function messages()
   {
      return [
         'pegawai' => [
            'required' => 'Pegawai Belum dipilih',
         ],
         'nomor_pengantar' => [
            'required' => 'Nomor Pengantar Surat Wajib di isi',
         ],
         'tgl_pengantar' => [
            'required' => 'Tanggal Pengantar Surat Wajib di isi',
         ],
         'rekom_jenis' => [
            'required' => 'Jenis Rekomendasi Wajib di isi',
         ],
         'keperluan_id' => [
            'required' => 'Keperluan Rekomendasi Wajib di isi',
         ],
         'file_sk' => [
            'required' => 'File SK PNS Wajib di isi',
            'mimes' => 'Format File SK PNS tidak cocok'
         ],
         'file_pengantar_opd' => [
            'required' => 'File Pengantar OPD Wajib di isi',
            'mimes' => 'Format file File Pengantar OPD tidak cocok'

         ],
         'file_konversi_nip' => [
            'mimes' => 'Format file File Pengantar OPD tidak cocok'
         ],
         


      ];
   }
}
