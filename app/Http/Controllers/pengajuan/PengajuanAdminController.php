<?php

namespace App\Http\Controllers\Pengajuan;

use App\Config\PengajuanAksi;
use App\Config\Role;
use App\Http\Controllers\Controller;
use App\Http\Services\Pegawai\PengajuanService;
use App\Models\File;
use App\Models\Keperluan;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
         )->latest();

      $pegawai = Cache::get('pegawai');

      if (request()->ajax()) {
         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
               return view('pengajuan.admin.action', compact('data'));
            })
            ->editColumn('status', function ($data) {
               $status = $this->pengajuanService->cekPengajuanStatus($data->uuid);
               return view('pengajuan.status', compact('status'));
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      return view('pengajuan.admin.index', $x, compact('data'));
   }

   public function kirim(Request $request, User $user)
   {
      try {

         DB::beginTransaction();
         if ($request->aksi_id == PengajuanAksi::SELESAI) {

            // OPD asal Pengirim
            $penerima  = Pengajuan::with('pengirim')
               ->where('uuid', '=', $request->pengajuan_uuid)
               ->first();

            $user_pengirim_opd_uuid  = User::find($penerima->pengirim_id)->uuid;

            $this->pengajuanService->storeHistori(
               $request->pengajuan_uuid,
               6,
               $user_pengirim_opd_uuid
            );

            $message = 'Pengajuan Berkas berhasil diselesaikan';
         } else if ($request->aksi_id == PengajuanAksi::TOLAK) {

            $penerima  = Pengajuan::with('pengirim')
               ->where('uuid', '=', $request->pengajuan_uuid)
               ->first();

            $user_pengirim_opd_uuid  = User::find($penerima->pengirim_id)->uuid;

            $this->pengajuanService->storeHistori(
               $request->pengajuan_uuid,
               PengajuanAksi::TOLAK,
               $user_pengirim_opd_uuid,
               $request->pesan
            );
            $message = '';
         } else {
            $this->pengajuanService->storeHistori(
               $request->pengajuan_uuid,
               $request->aksi_id,
               $request->penerima_uuid
            );
         }
         // if ($user->getRoleName() == Role::isInspektur) {
         //    $this->pengajuanService->storeHistori(
         //       $request->pengajuan_uuid,
         //       PengajuanAksi::PROSES_SURAT,
         //       $request->penerima_uuid
         //    );
         // }
         $message = '';

         DB::commit();
         return redirect()->back()->with('success-modal', ['title' => 'Berhasil', 'message' => $message], 200)->send();
      } catch (\Throwable $th) {
         DB::rollback();
         return redirect()->back()->with('error-modal', 'Gagal : ' . $th->getMessage(), 400)->send();
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
         ->where('uuid', '=', $uuid)
         ->whereHas('histori', function (Builder $query) {
            $query->where('pengajuan_aksi_id', '=', PengajuanAksi::VERIFIKASI_DATA);
            $query->where('penerima_id', '=', auth()->user()->id);
         })
         ->first();

      // jika belum ada maka insert histori pengajuan dengan status proses
      if ($histori == null && $user->getRoleName() == Role::isAdminInspektorat) {
         $pengajuanService->storeHistori($uuid, PengajuanAksi::VERIFIKASI_DATA, auth()->user()->uuid);
      }
      if ($histori == null && $user->getRoleName() == Role::isKasubag) {
         $pengajuanService->storeHistori($uuid, PengajuanAksi::VERIFIKASI_DATA, auth()->user()->uuid);
      }
      if ($histori == null && $user->getRoleName() == Role::isInspektur) {
         $pengajuanService->storeHistori($uuid, PengajuanAksi::VERIFIKASI_DATA, auth()->user()->uuid);
      }

      $view_aksi = $this->pengajuanService->getViewAksiDetail($uuid);

      $user_kirim = $pengajuan->getUserKirim();
      $file_rekom_hasil = $pengajuan->getFileRekomHasil();
    
     

      $pengajuan = $pengajuan->getPengajuanWithData($uuid);

      $keperluan = Keperluan::get();

      return view(
         'pengajuan.detail',
         $x,
         compact(['status', 'keperluan', 'pengajuan', 'user_kirim', 'user', 'view_aksi', 'file_rekom_hasil'])
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
         return redirect()->back()->with('error', 'Gagal Menghapus Data ' . $th, 400)->send();
      }
   }
}
