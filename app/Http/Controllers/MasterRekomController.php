<?php

namespace App\Http\Controllers;

use App\Http\Services\Pegawai\PegawaiService;
use App\Models\MasterRekom;
use App\Models\OPD;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class MasterRekomController extends Controller
{
   protected $pegawaiService;

   public function __construct(PegawaiService $pegawaiService)
   {
      $this->pegawaiService = $pegawaiService;
   }

   public function index(Request $request)
   {

      $x['title'] = 'Master Rekom Pegawai';
      $data = MasterRekom::with('opd')->latest('id');

      if ($request->rekom_jenis == 'DISIPLIN') {
         $data->where('rekom_jenis', 'DISIPLIN');
      }

      if ($request->rekom_jenis == 'TEMUAN') {
         $data->where('rekom_jenis', 'TEMUAN');
      }

      if (request()->ajax()) {
         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
               return view('master-rekom.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      return view('master-rekom.index', $x, compact('data'));
   }


   public function create(Request $request)
   {
      $pegawai = $this->pegawaiService->getAll();
      $opd = OPD::get();
      if ($request->has('disiplin')) {
         $x['title'] = 'Input Data Disiplin';
         return view('master-rekom.input-disiplin', $x, compact('pegawai', 'opd'));
      }
      if ($request->has('temuan')) {
         $x['title'] = 'Input Data Temuan';
         return view('master-rekom.input-temuan', $x, compact('pegawai', 'opd'));
      }
   }


   public function store(Request $request)
   {
      try {
         $input = $request->except(['opd']);
         $pegawai = $this->pegawaiService->filterByNIP($request->nip)[0];
         $input['nama'] = $pegawai['nama'];
         $input['kunker'] = $pegawai['kunker'];
         MasterRekom::create($input);
         return redirect()->route('master-rekom.index')->with('success', 'Berhasil ', 200)->send();
      } catch (\Throwable $th) {
         return redirect()->back()->with('error', 'Gagal' . $th, 400)->send();
      }
   }

   public function show(MasterRekom $masterRekom)
   {
      //
   }


   public function edit(MasterRekom $masterRekom)
   {

      $kunker = $this->pegawaiService->filterByNIP($masterRekom->nip)[0]['kunker'];


      $opd = OPD::get();
      if ($masterRekom->rekom_jenis == 'DISIPLIN') {
         $x['title'] = 'Ubah Data Disiplin';
         return view('master-rekom.edit-disiplin', $x, compact(['kunker', 'opd',  'masterRekom']));
      }
      if ($masterRekom->rekom_jenis == 'TEMUAN') {
         $x['title'] = 'Ubah Data Temuan';
         return view('master-rekom.edit-temuan', $x, compact(['kunker', 'opd',  'masterRekom']));
      }
   }

   public function update(Request $request, MasterRekom $masterRekom)
   {
      try {
         $input = $request->except(['opd']);
         $pegawai = $this->pegawaiService->filterByNIP($request->nip)[0];
         $input['nama'] = $pegawai['nama'];
         $input['kunker'] = $pegawai['kunker'];
         $masterRekom->fill($input)->save();
         return redirect()->route('master-rekom.index')->with('success', 'Berhasil ', 200)->send();
      } catch (\Throwable $th) {
         return redirect()->back()->with('error', 'Gagal' . $th, 400)->send();
      }
   }


   public function destroy(MasterRekom $masterRekom)
   {
      try {
         MasterRekom::destroy($masterRekom->id);
         return redirect()->back()->with('success', 'Berhasil Hapus Data', 200)->send();
      } catch (\Throwable $th) {
         return redirect()->back()->with('error', 'Gagal Hapus Data', 400)->send();
      }
   }
}
