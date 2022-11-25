<?php

namespace App\Utils;

class MyLog
{
   public function save($model, $request){
      activity()
      ->causedBy($model)
      ->useLog($request->route()->getActionMethod())
      ->event('verified')
      ->log('edited');
   }
}
