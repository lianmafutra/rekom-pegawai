<?php

namespace App\Utils;

class RemoveSpace
{
   public static function  removeDoubleSpace($string){
      $data = preg_replace('/\s+/', ' ', $string);
      $string = str_replace(" ", "-", $data);
      return $string;
   }
}
