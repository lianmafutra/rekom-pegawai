<?php

namespace App\Utils;

trait MyLog
{
   public function saveLog($request){
      activity()
      ->useLog(request()->route()->getActionMethod())
      ->withProperties([
         "user" => auth()->user()->username,
         "role" => auth()->user()->roles->pluck('name')[0],
         "method" => \Route::current()->methods()[0],
         "file" => \Route::currentRouteAction(),
         "ip" => request()->ip(),
      ])
      ->event('verified')
      ->log('edited');
   }
}
