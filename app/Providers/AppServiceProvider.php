<?php
namespace App\Providers;
use App\Config\PengajuanAksi;
use App\Config\Role;
use App\Http\Services\Pegawai\PengajuanService;
use App\Models\Pengajuan;
use App\Models\PengajuanHistori;
use App\Models\User;
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
         
         if (Auth::check()) {
            $view->with('user_data', Auth::user());
            $global_jumlah_notif = PengajuanHistori::where('penerima_id', auth()->user()->id);
           
            if((new User())->getRoleName() == Role::isAdminOpd){
               $global_jumlah_notif->where('tgl_aksi', NULL)->whereIn('pengajuan_aksi_id', [PengajuanAksi::SELESAI, PengajuanAksi::TOLAK]);
            }else{
               $global_jumlah_notif->where('tgl_aksi', NULL)->whereNotIn('pengajuan_aksi_id', [PengajuanAksi::VERIFIKASI_DATA, PengajuanAksi::PROSES_SURAT, PengajuanAksi::SELESAI]);
            }

            $view->with('global_jumlah_notif',  $global_jumlah_notif->count());

         } else {
            $view->with('user_data', null);
         }
      });
   }
}
