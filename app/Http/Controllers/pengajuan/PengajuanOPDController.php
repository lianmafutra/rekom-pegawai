<?php

namespace App\Http\Controllers\pengajuan;

use App\Config\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanOPDStoreRequest;
use App\Http\Services\Pegawai\PegawaiService;
use App\Http\Services\Pegawai\PengajuanService;
use App\Models\Keperluan;
use App\Models\Pengajuan;
use App\Models\User;
use App\Utils\uploadFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class PengajuanOPDController extends Controller
{

   public function index()
   {

      abort_if(Gate::denies('pengajuan index'), 403);

      $x['title']     = 'Pengajuan OPD';
      $data = Pengajuan::with('keperluan')->get();
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


   public function store(PengajuanOPDStoreRequest $request, uploadFile $uploadFile, PegawaiService $pegawaiService)
   {
      abort_if(Gate::denies('pengajuan store'), 403);

      try {
         DB::beginTransaction();

         // ambil data pegawai dari api cache BKD
         $pegawai_cache = $pegawaiService->filterByNIP($request->pegawai)[0];
         $pengajuanService = new PengajuanService();

         $pengajuan = Pengajuan::create([
            'nip'                 => $pegawai_cache['nipbaru'],
            'gldepan'             => $pegawai_cache['gldepan'],
            'glblk'               => $pegawai_cache['glblk'],
            'nama'                => $pegawai_cache['nama'],
            'kunker'              => $pegawai_cache['kunker'],
            'nunker'              => $pegawai_cache['nunker'],
            'kjab'                => $pegawai_cache['kjab'],
            'njab'                => $pegawai_cache['njab'],
            'keselon'             => $pegawai_cache['keselon'],
            'neselon'             => $pegawai_cache['neselon'],
            'kgolru'              => $pegawai_cache['kgolru'],
            'ngolru'              => $pegawai_cache['ngolru'],
            'pangkat'             => $pegawai_cache['pangkat'],
            'photo'               => $pegawai_cache['photo'],
            'nomor_pengantar'     => $request->nomor_pengantar,
            'tgl_surat_pengantar' => $request->tgl_pengantar,
            'rekom_jenis'         => $request->rekom_jenis,
            'rekom_keperluan_id'  => $request->rekom_keperluan_id,
            'pengirim_id'         => auth()->user()->id,
            'penerima_id'         => $pengajuanService->getPenerimaOpdId(),
            'penerima_opd_id'     => $pengajuanService->getPenerimaOpdId(),
            'file_sk_terakhir'    => Str::uuid()->toString(),
            'file_pengantar'      => Str::uuid()->toString(),
            'file_konversi_nip'   => Str::uuid()->toString(),
            'catatan'             => $request->catatan,
         ]);

         // upload file syarat pengajuan

         $uploadFile
            ->file($request->file('file_sk'))
            ->path('pengajuan')
            ->uuid($pengajuan->file_sk_terakhir)
            ->parent_id($pengajuan->id)
            ->save();

         $uploadFile
            ->file($request->file('file_pengantar_opd'))
            ->path('pengajuan')
            ->uuid($pengajuan->file_pengantar)
            ->parent_id($pengajuan->id)
            ->save();

         $uploadFile
            ->file($request->file('file_konversi_nip'))
            ->path('pengajuan')
            ->uuid($pengajuan->file_konversi_nip)
            ->parent_id($pengajuan->id)
            ->save();

         DB::commit();
         return redirect()->route('pengajuan.index')->with('success', 'Berhasil ', 200)->send();
      } catch (\Throwable $th) {
         dd($th);
         DB::rollBack();
         return redirect()->back()->with('error', 'Gagal' . $th, 400)->send();
      }
   }


   public function show(Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan show'), 403);
   }

   public function edit(Pengajuan $pengajuan)
   {
      $x['title']     = 'Ubah Pengajuan';
      abort_if(Gate::denies('pengajuan edit'), 403);
      return view('pengajuan-opd.edit', $x, compact('pengajuan'));
   }

   public function update(Request $request, Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan update'), 403);
   }

   public function destroy(Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan destroy'), 403);
   }
}
