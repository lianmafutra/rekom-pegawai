<?php

namespace App\Http\Controllers\Pengajuan;

use App\Config\PengajuanAksi;
use App\Config\Role;
use App\Http\Controllers\Controller;
use App\Http\Services\Pegawai\PengajuanService;
use App\Models\Keperluan;
use App\Models\Pengajuan;
use App\Models\PengajuanHistori;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;


class PengajuanAdminController extends Controller
{

   private $pengajuanService;

   public function __construct(PengajuanService $pengajuanService)
   {
      $this->pengajuanService = $pengajuanService;
   }

   public function index()
   {
      abort_if(Gate::denies('pengajuan verifikasi index'), 403);

      $x['title'] = 'Pengajuan Verifikasi';
      $data    = Pengajuan::with('keperluan', 'histori')
         ->whereRelation(
            'histori',
            'penerima_id',
            '=',
            auth()->user()->id
         )->latest()->get();

      $pegawai = Cache::get('pegawai');

      if (request()->ajax()) {
         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
               return view('pengajuan.admin.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      return view('pengajuan.admin.index', $x, compact('data'));
   }

   public function kirim(Request $request)
   {
      try {

         DB::beginTransaction();
         $user = User::with('opd')->find(auth()->user()->id);

         $penerima_id    = Pengajuan::with('pengirim')
            ->where('uuid', '=', $request->pengajuan_uuid)
            ->first();

         $pengajuan_id = Pengajuan::where('uuid', $request->pengajuan_uuid)->first()->id;

         // $this->pengajuanService->updateTglProses($pengajuan_id);

         $this->pengajuanService->storeHistori(
            $request->pengajuan_uuid,
            $request->aksi_id,
            $request->penerima_uuid
         );
         DB::commit();
         return redirect()->back()->with('success', 'Berhasil ', 200)->send();
      } catch (\Throwable $th) {
         DB::rollback();
         return redirect()->back()->with('error', 'Gagal : ' . $th->getMessage(), 400)->send();
      }
   }

   public function detail($uuid, Pengajuan $pengajuan, User $user)
   {

      $x['title'] = 'Buat Pengajuan';

      $status = $this->pengajuanService->cekPengajuanStatus($uuid);

      // $this->pengajuanService->cekHistoriProsesAdminOpd($uuid);

      $user = new User();
      $pengajuanService = new PengajuanService();

      $histori  = Pengajuan::with(['histori'])
      ->whereRelation('histori', 'pengajuan_aksi_id', '=', PengajuanAksi::VERIFIKASI_DATA)
      ->where('uuid', '=', $uuid)
      ->first();


      // jika belum ada maka insert histori pengajuan dengan status proses
      if ($histori == null && $user->getRoleName() == Role::isAdminInspektorat) {
         $pengajuanService->storeHistori($uuid, PengajuanAksi::VERIFIKASI_DATA);
      }
     
      $view_aksi = $this->pengajuanService->getViewAksiDetail($uuid);

      $user_kirim = $pengajuan->getUserKirim();

      $pengajuan = $pengajuan->getPengajuanWithData($uuid);

      $keperluan = Keperluan::get();

      return view(
         'pengajuan.detail',
         $x,
         compact(['status', 'keperluan', 'pengajuan', 'user_kirim', 'user', 'view_aksi'])
      );
   }


 
   
   public function destroy($uuid)
      {
         try {
            DB::beginTransaction();
           $pengajuan = Pengajuan::where('uuid', $uuid)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil Hapus Data', 200)->send();
         } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal Menghapus Data '.$th, 400)->send();
         }   
      }
}
