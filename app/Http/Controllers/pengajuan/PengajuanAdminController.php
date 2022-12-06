<?php

namespace App\Http\Controllers\Pengajuan;

use App\Config\Pengajuan as ConfigPengajuan;
use App\Config\PengajuanAksi;
use App\Config\PengajuanKirim;
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
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;


class PengajuanAdminController extends Controller
{

   public function index()
   {
      abort_if(Gate::denies('pengajuan verifikasi index'), 403);


      $x['title'] = 'Pengajuan Verifikasi';
      $data    = Pengajuan::with('keperluan')->latest()->get();
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

   public function kirim(Request $request, PengajuanService $pengajuanService)
   {
      try {
         $user = User::with('opd')->find(auth()->user()->id);

         $penerima_id    = Pengajuan::with('pengirim')
         ->where('uuid', '=', $request->pengajuan_uuid)
         ->first();

      
         $pengajuan_id = Pengajuan::where('uuid', $request->pengajuan_uuid)->first()->id;

         if ($request->has('selesai')) {
            PengajuanHistori::create([
               'pengajuan_id'      => $pengajuan_id,
               'user_id'           => $user->id,
               'user_nama'         => $penerima_id->pengirim->name,
               'penerima_id'       => $penerima_id->pengirim->id,
               'pengirim_id'       => $user->id,
               'opd'               => $user->opd->nunker,
               'pengajuan_aksi_id' => PengajuanAksi::SELESAI,
               'pesan'             => '',
               'tgl_kirim'         => Carbon::now(),
            ]);
         } else {
            $pengajuanService->storeHistori(
               $request->pengajuan_uuid,
               $request->aksi_id,
               $request->penerima_uuid
            );
         }


         return redirect()->back()->with('success', 'Berhasil ', 200)->send();
      } catch (\Throwable $th) {
         return redirect()->back()->with('error', 'Gagal : ' . $th->getMessage(), 400)->send();
      }
   }

   public function detail($uuid, Pengajuan $pengajuan, PengajuanService $pengajuanService)
   {
      // abort_if(Gate::denies('pengajuan create'), 403);

      $x['title']     = 'Buat Pengajuan';
      $x['url_foto']     = Config::get('global.url.bkd.foto');
      $x['rekom_jenis']     = Config::get('global.rekom_jenis');

      $histori  = Pengajuan::with(['histori'])
         ->whereRelation('histori', 'pengajuan_aksi_id', '=', PengajuanAksi::PROSES)
         ->where('uuid', $uuid)
         ->first();

      if ($histori == null && auth()->user()->getRoleNames()[0] == Role::isAdminInspektorat) {
         $pengajuanService->storeHistori($uuid, PengajuanAksi::PROSES, '26cabc5d-7c32-4e97-83f0-a02a226783c5');
      }

      $pengajuan  = Pengajuan::with(['keperluan', 'file_sk', 'file_pengantar', 'file_konversi'])->where('uuid', $uuid)->first();

      $user_kirim = $pengajuan->getUserKirim();

      $keperluan  = Keperluan::get();
      return view('pengajuan.opd.detail', $x, compact('user_kirim', 'keperluan', 'pengajuan', 'user_kirim'));
   }
}
