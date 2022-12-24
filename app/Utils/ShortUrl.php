<?php

namespace App\Utils;
use Illuminate\Support\Str;
class ShortUrl
{
   public function generate($id){
      $randomString = Str::random(4);
      return $randomString.$id;
   }
}
