@extends('admin.layouts.master-custom')
@push('css')
@endpush
@section('content')
    <div style="padding: 50px" class="col-md-12">
        <div class="">
            <div class="card card-default">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-search"></i>
                        Validasi Berkas
                    </h2>
                </div>
                <div class="card-body">
                    <h4  style="padding: 20px; text-align: center;">Sistem SITERE ..., menyatakan bahwa:</h4>
                    @if ($pengajuan)
                        <div class="card-body">
                            <div class="callout callout-info">
                                <table  border="0" style="font-size: 18px;">
                                    <tbody>
                                        <tr>
                                            <td width="10%"></td>
                                            <td width="20%">No. Pengantar</td>
                                            <td width="3%">:</td>
                                            <td width="65%">{{ $pengajuan->nomor_pengantar }}</td>
                                        </tr>
                                        <tr>
                                          <td width="10%"></td>
                                          <td>Tanggal Surat Pengantar</td>
                                          <td>:</td>
                                          <td>{{ $pengajuan->tgl_surat_pengantar }}</td>
                                      </tr>
                                        <tr>
                                          <td width="10%"></td>
                                          <td width="20%">Perihal</td>
                                          <td width="3%">:</td>
                                          <td width="65%">Surat Rekomendasi {{ $pengajuan->getRekomJenisNamaAttribute() }}</td>
                                      </tr>
                                        <tr>
                                            <td width="10%"></td>
                                            <td>Nama Pemohon</td>
                                            <td>:</td>
                                            <td>{{ $pengajuan->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td width="10%"></td>
                                            <td>JABATAN</td>
                                            <td>:</td>
                                            <td>{{ $pengajuan->njab }}</td>
                                        </tr>

                                        <tr>
                                          <td width="10%"></td>
                                          <td>OPD</td>
                                          <td>:</td>
                                          <td>{{ $pengajuan->nunker }}</td>
                                      </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p  style="padding: 30px; text-align: center; font-size: 19px">
                           Adalah benar dan tercatat dalam database Kami.
                           Untuk memastikan bahwa surat tersebut benar, pastikan bahwa URL pada browser Anda adalah<br>
                           <b>{{  'https://sitere.jambikota.go.id' }}</b>
                       </p>
                    @else
                        <div class="callout callout-danger">
                            <h5> Maaf Berkas tidak ditemukan dalam database kami !</h5>
                        </div>
                    @endif
                   
                </div>
            </div>
        </div>
    </div>
@endsection
