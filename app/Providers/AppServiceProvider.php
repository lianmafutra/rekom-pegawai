<?php

namespace App\Providers;

use App\Config\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
   /**
    * Register any application services.
    *
    * @return void
    */
   public function register()
   {
      //
   }

   /**
    * Bootstrap any application services.
    *
    * @return void
    */
   public function boot()
   {
      view()->composer('*', function ($view) {
      



         // $jumlah_notif = Pengajuan::with('histori')
         //    ->where('tgl_proses', null)
         //    ->where('penerima_id', auth()->user()->id)
         //    ->count();

         $view->with('global_jumlah_notif', 0);

         if (Auth::check()) {
            $view->with('user_data', Auth::user());
         } else {
            $view->with('user_data', null);
         }
      });
   }
}
