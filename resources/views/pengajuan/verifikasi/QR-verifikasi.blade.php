@extends('admin.layouts.master-custom')
@push('css')
@endpush
@section('content')
<div style="padding: 50px" class="col-md-12">
   <div class="card">
      <div class="card card-default">
         <div class="card-header">
            <h3 class="card-title">
               <i class="fas fa-search"></i>
               Validasi Berkas
            </h3>
         </div>

         @if ($pengajuan)
         <div class="card-body">
            <div class="callout callout-info">
               <h5>Berkas Valid</h5>
               <p>No. Pengantar :{{ $pengajuan->nomor_pengantar }}</p>
               <p>Nama : {{ $pengajuan->nama }}</p>
               <p>JABATAN : {{ $pengajuan->njab }}</p>
               <p>OPD : {{ $pengajuan->nunker }}</p>
            </div>
         </div>
         @else
         <div class="callout callout-danger">
            <h5> Maaf Berkas tidak ditemukan dalam database kami !</h5>
         </div>
         @endif

      </div>
   </div>
</div>
@endsection