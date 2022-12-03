<?php

namespace App\Http\Controllers\pengajuan;

use App\Config\PengajuanAksi;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanOPDStoreRequest;
use App\Http\Services\Pegawai\PegawaiService;
use App\Http\Services\Pegawai\PengajuanService;
use App\Models\Keperluan;
use App\Models\Pengajuan;
use App\Models\User;
use App\Utils\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class PengajuanOPDController extends Controller
{

   public function index()
   {

      abort_if(Gate::denies('pengajuan index'), 403);

      $x['title'] = 'Pengajuan OPD';
      $data    = Pengajuan::with('keperluan')->latest()->get();
      $pegawai = Cache::get('pegawai');

      if (request()->ajax()) {
         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
               return view('pengajuan-opd.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      return view('pengajuan-opd.index', $x, compact('data'));
   }

   public function create(PegawaiService $pegawaiService, User $user)
   {

      abort_if(Gate::denies('pengajuan create'), 403);
      $x['title']     = 'Buat Pengajuan';
      $x['url_foto']     = Config::get('global.url.bkd.foto');
      $x['rekom_jenis']     = Config::get('global.rekom_jenis');

      $pegawai = $pegawaiService->filterByOPD($user->getWithOpd()->kunker);
      $keperluan = Keperluan::get();
      return view('pengajuan-opd.create', $x, compact('pegawai', 'keperluan'));
   }


   public function store(PengajuanOPDStoreRequest $request, PegawaiService $pegawaiService, PengajuanService $pengajuanService)
   {
      abort_if(Gate::denies('pengajuan store'), 403);

      try {

         // Ambil data pegawai dari cache ( API BKD )
         $pegawai_cache = $pegawaiService->filterByNIP($request->pegawai)[0];

         // Insert data pengajuan ke DB
         $pengajuanStore = $pengajuanService->storePengajuan($pegawai_cache, $request);

         // Insert histori pengajuan ke DB
        $pengajuanService->storeHistori($pengajuanStore->id, PengajuanAksi::KIRIM);

         // upload file syarat pengajuan
         $upload_file_sk        = new UploadFile();
         $upload_file_pengantar = new UploadFile();
         $upload_file_konversi  = new UploadFile();

         $upload_file_sk->file($request->file('file_sk'))
            ->path('pengajuan')
            ->uuid($pengajuanStore->file_sk_terakhir)
            ->parent_id($pengajuanStore->id);

         $upload_file_pengantar
            ->file($request->file('file_pengantar_opd'))
            ->path('pengajuan')
            ->uuid($pengajuanStore->file_pengantar)
            ->parent_id($pengajuanStore->id);

         $upload_file_konversi //optional
            ->file($request->file('file_konversi_nip'))
            ->path('pengajuan')
            ->uuid($pengajuanStore->file_konversi_nip)
            ->parent_id($pengajuanStore->id);

         if (!$upload_file_sk->save() || !$upload_file_pengantar->save() || !$upload_file_konversi->save()) {
            throw new CustomException("Terjadi Kesalahan saat mengupload File");
         }

         DB::commit();
         return redirect()->route('pengajuan.index')->with('success', 'Berhasil ', 200)->send();
      } catch (\Throwable $th) {
         DB::rollBack();
         return redirect()->back()->with('error', 'Gagal : ' . $th->getMessage(), 400)->send();
      }
   }

   public function show(Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan show'), 403);
      $pengajuan = Pengajuan::with(['keperluan', 'file_sk', 'file_pengantar', 'file_konversi'])->where('uuid', $pengajuan->uuid)->first();
      return response()->json($pengajuan);
   }

   public function edit(Pengajuan $pengajuan, PegawaiService $pegawaiService, User $user)
   {
      abort_if(Gate::denies('pengajuan edit'), 403);
      $x['title']       = 'Ubah Pengajuan';
      $x['url_foto']    = Config::get('global.url.bkd.foto');
      $x['rekom_jenis'] = Config::get('global.rekom_jenis');
      $pegawai = $pegawaiService->filterByOPD($user->getWithOpd()->kunker);
      $keperluan = Keperluan::get();
      return view('pengajuan-opd.edit', $x, compact('pegawai', 'keperluan', 'pengajuan'));
   }

   public function update(Request $request, Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan update'), 403);
   }

   public function destroy(Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan destroy'), 403);
   }

   public function histori($uuid)
   {
      $pengajuan = Pengajuan::with(['histori', 'histori.aksi'])->whereUuid($uuid)->first();
      return $this->success($pengajuan, 'Histori Pengajuan');
   }
}
