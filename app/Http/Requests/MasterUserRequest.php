<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterUserRequest extends FormRequest
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

      if (in_array($this->method(), ['PUT', 'PATCH'])) {
         return [
            'username' => 'required|min:5',
            'opd_id'   => 'required',
         ];
      }

      if (in_array($this->method(), ['POST'])) {
         return [
            'username' => 'required|min:5',
            'opd_id'   => 'required',
            'password' => 'required|min:5',
         ];
      }
   }
}
