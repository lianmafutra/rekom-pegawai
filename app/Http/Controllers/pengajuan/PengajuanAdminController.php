<?php

namespace App\Http\Controllers\Pengajuan;

use App\Config\PengajuanAksi;
use App\Config\Role;
use App\Http\Controllers\Controller;
use App\Http\Services\Pegawai\PengajuanService;
use App\Models\Keperluan;
use App\Models\OPD;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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

   public function index(Request $request)
   {
      abort_if(Gate::denies('pengajuan verifikasi index'), 403);

      $x['title'] = 'Pengajuan Verifikasi';
      $x['status'] = $request->status;
      $x['opd'] = OPD::get();

      if ($request->status == 'belum-direspon') {
         $data = Pengajuan::with('keperluan', 'histori')->whereHas('histori', function (Builder $query) {
            $query->where('penerima_id', '=', auth()->user()->id);
            $query->where('tgl_aksi', '=', NULL);
            $query->whereNotIn('pengajuan_aksi_id', [PengajuanAksi::VERIFIKASI_DATA, Pengajuanaksi::PROSES_SURAT, Pengajuanaksi::SELESAI]);
         });
      } else if ($request->status == 'semua') {
         $data = Pengajuan::with('keperluan', 'histori')->whereHas('histori', function (Builder $query) use ($request) {
            // $query->where('penerima_id', '=', auth()->user()->id);
            // $query->where('tgl_aksi', '=', NULL);
            $query->where('pengajuan_aksi_id',  6);
         });

         if ($request->opd_id) {
            $data->where('nunker', 'LIKE', '%' . $request->opd_id . '%');
         }

         if ($request->rekom_jenis) {
            $data->where('rekom_jenis', $request->rekom_jenis);
         }

         // if ($request->status_pengajuan == 'proses') {
         //    $query->whereIn('pengajuan_aksi_id', [1, 2, 3, 4, 5, 7]);
         // }
         
         // else if ($request->status_pengajuan == 'selesai') {
         //    $data->whereHas(
         //       'histori',
         //       fn ($q) => $q->whereIn('pengajuan_aksi_id',[6])
         //    );
         // }
         // else if  ($request->status_pengajuan == 'tolak') {
         //    $data->whereHas(
         //       'histori',
         //       fn ($q) => $q->whereIn('pengajuan_aksi_id',[8])
         //    );
         // }
         // if ($request->status_pengajuan == 'tolak') {
         //    $query->whereIn('pengajuan_aksi_id', [8]);
         // }



      } else {
         return abort(404);
      }

      if (request()->ajax()) {
         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
               return view('pengajuan.admin.action', compact('data'));
            })
            ->editColumn('created_at', function ($data) {
               return $data->tgl_kirim;
            })
            ->editColumn('status', function ($data) {
               $status = $this->pengajuanService->cekPengajuanStatus($data->uuid);
               return view('pengajuan.status', compact('status'));
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      return view('pengajuan.admin.index', $x);
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

      if ($status != PengajuanAksi::TOLAK) {
         // jika belum ada maka insert histori pengajuan dengan status proses
         if ($histori == null && $user->getRoleName() != Role::isAdminOpd) {
            $pengajuanService->storeHistori($uuid, PengajuanAksi::VERIFIKASI_DATA, auth()->user()->uuid);
         }
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
