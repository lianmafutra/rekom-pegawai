<?php

namespace App\Providers;

use App\Config\PengajuanAksi;
use App\Http\Services\Pegawai\PengajuanService;
use App\Models\Pengajuan;
use App\Models\PengajuanHistori;
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



         $global_jumlah_notif = PengajuanHistori::where('penerima_id', auth()->user()->id)
         ->where('tgl_aksi', NULL)
         ->whereNotIn('pengajuan_aksi_id', [2,5]);
        
        

            


         $view->with('global_jumlah_notif',  $global_jumlah_notif->count());

         if (Auth::check()) {
            $view->with('user_data', Auth::user());
         } else {
            $view->with('user_data', null);
         }
      });
   }
}
