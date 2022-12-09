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
         'file_sk'            => 'required:mimes:pdf|file|size:1024',
         'file_pengantar_opd' => 'required:mimes:pdf|file|size:1024',
         'file_konversi_nip'  => 'mimes:pdf|file|size:1024',
      ];
   }

   public function messages()
   {     
      return [
         'pegawai' => [
            'required' => 'We need to know your email address!',
         ],
         'nomor_pengantar' => [
            'required' => 'We need to know your email address!',
         ],
         'tgl_pengantar' => [
            'required' => 'We need to know your email address!',
         ],
         'rekom_jenis' => [
            'required' => 'We need to know your email address!',
         ],
         'keperluan_id' => [
            'required' => 'We need to know your email address!',
         ],
         'file_sk'                  => 'mimes:pdf|file|size:1024',
         'file_pengantar_opd'       => 'mimes:pdf|file|size:1024',
         'file_konversi_nip'        => 'mimes:pdf|file|size:1024',
      ];
   }

   
}
