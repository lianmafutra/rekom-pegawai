<?php

namespace App\Http\Requests;

use App\Rules\CheckPassword;
use Illuminate\Foundation\Http\FormRequest;

class CetakRekomRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
      return [
         'password'            => ['required', 'min:3', new CheckPassword],
      ];
    }

    public function messages()
    {
      return [
         'pegawai' => [
            'required' => 'Password Belum Diisi',
         ],
      ];
    }
}
