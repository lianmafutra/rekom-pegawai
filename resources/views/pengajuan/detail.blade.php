@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('content')
    <style>
        .timeline {
            max-height: 962px;
            overflow-y: scroll;
            margin: 0 0 45px;
            padding: 0;
            position: relative;
        }

        .timeline::-webkit-scrollbar-track {
            border: 1px solid rgb(184, 184, 184);  
            padding: 2px 0;
            background-color: #e4e4e4;
        }

        .timeline::-webkit-scrollbar {
            width: 10px;
        }

        .timeline::-webkit-scrollbar-thumb {
            border-radius: 10px;
            box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: rgba(175, 175, 175, 0.747);
            /* border: 1px solid #000; */
        }

        tr td:first-child {
            color: #313131;
            font-weight: bold;
        }

        .column {
            width: 100%;
        }

        .ico {
            color: orange;
            display: inline-block;
            float: left;
            width: 18px;
            height: 32px;
            margin-top: -6px;
            line-height: 32px;
            background-position: 0 0;
            background-repeat: no-repeat;
        }

        .title {
            display: block;
            overflow: hidden;
        }

        .profile-custom {
            border: 1px solid #adb5bd !important;
            margin: 0 auto;
            border-radius: 5%;
            background-position: center center;
            background-repeat: no-repeat;
            width: 174px;
            object-fit: cover;
            height: 196px;
            margin-bottom: 20px;
        }

        .filepond--drop-label.filepond--drop-label label {
            font-weight: 200 !important;
        }

        .info-data-api {
            font-size: 11px;
            color: #9459fd;
        }

        .loading-custom {
            display: none;
            z-index: 9999999;
            left: 0;
            width: 120px;
            right: 0;
            top: 130px;
            margin-left: auto;
            margin-right: auto;
            position: absolute
        }

        .profile-custom {
            border: 1px solid #adb5bd !important;
            margin: 0 auto;
            border-radius: 5%;
            background-position: center center;
            background-repeat: no-repeat;
            width: 250px;
            object-fit: cover;
            height: 300px;
        }

        .form-control {
            font-size: 14px !important;
        }

        div# {
            position: relative;
            margin-top: -10px;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Pengajuan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pengajuan Rekomendasi</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title font-weight-bold">Data Pengajuan</h5>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="col-md-12">
                                        <form id="form_pengajuan" action="{{ route('pengajuan.store') }}" method="POST"
                                            autocomplete="off" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <table class="table ">
                                                <tbody>
                                                    <div class="card-body box-profile">
                                                        <img class="loading loading-custom"
                                                            src="{{ asset('img/loading.gif') }}">
                                                        <div class="profile_data">
                                                            <div class="text-center">
                                                                <img class="profile-user-img profile-custom  img-fluid img-circle"
                                                                    src="{{ config('global.url.bkd.foto') . $pengajuan->photo }}"
                                                                    alt="User profile picture">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <tr>
                                                        <td>NIP</td>
                                                        <td>:</td>
                                                        <td id="nip">{{ $pengajuan->nip }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Pegawai</td>
                                                        <td>:</td>
                                                        <td id="nama">{{ $pengajuan->nama }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pangkat/Gol</td>
                                                        <td>:</td>
                                                        <td id="pangkat">{{ $pengajuan->pangkat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jabatan</td>
                                                        <td>:</td>
                                                        <td id="jabatan">{{ $pengajuan->njab }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>OPD</td>
                                                        <td>:</td>
                                                        <td id="opd">{{ $pengajuan->nunker }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nomor Surat Pengantar</td>
                                                        <td>:</td>
                                                        <td id="no_pengantar">{{ $pengajuan->nomor_pengantar }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Surat Pengantar</td>
                                                        <td>:</td>
                                                        <td id="tgl_pengantar">{{ $pengajuan->tgl_surat_pengantar }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Rekomendasi</td>
                                                        <td>:</td>
                                                        <td id="rekom_jenis">{{ $pengajuan->rekom_jenis_nama }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Keperluan Rekomendasi</td>
                                                        <td>:</td>
                                                        <td id="rekom_keperluan">{{ $pengajuan->keperluan->nama }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="color: grey; font-weight: bold">#Data File</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="column">
                                                                <i class="ico fas fa-file"></i>
                                                                <span class="title">File Sk Terakhir</span>
                                                            </div>
                                                        </td>
                                                        <td>:</td>
                                                        <td id="file_sk">
                                                            @if ($pengajuan->file_sk->isNotEmpty())
                                                                <a data-url="{{ 'http://' .
                                                                    request()->getHttpHost() .
                                                                    '/storage/' .
                                                                    $pengajuan->file_sk[0]->path .
                                                                    '/' .
                                                                    $pengajuan->file_sk[0]->name_random }}"
                                                                    href="#" type="button"
                                                                    class="btn_view_file btn btn-default btn-sm"> <i
                                                                        class="far fa-eye"></i> Lihat
                                                                    File
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="column">
                                                                <i class="ico fas fa-file"></i>
                                                                <span class="title">File Surat Pengantar kepala
                                                                    OPD</span>
                                                            </div>
                                                        </td>
                                                        <td>:</td>
                                                        <td id="file_pengantar">
                                                            @if ($pengajuan->file_pengantar->isNotEmpty())
                                                                <a data-url="{{ 'http://' .
                                                                    request()->getHttpHost() .
                                                                    '/storage/' .
                                                                    $pengajuan->file_pengantar[0]->path .
                                                                    '/' .
                                                                    $pengajuan->file_pengantar[0]->name_random }}"
                                                                    href="#" type="button"
                                                                    class="btn_view_file btn btn-default btn-sm">
                                                                    <i class="far fa-eye"></i> Lihat File
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="column">
                                                                <i class="ico fas fa-file"></i>
                                                                <span class="title">File Konversi NIP</span>
                                                            </div>
                                                        </td>
                                                        <td>:</td>
                                                        <td id="file_konversi">
                                                            @if ($pengajuan->file_konversi->isNotEmpty())
                                                                <a data-url="{{ 'http://' .
                                                                    request()->getHttpHost() .
                                                                    '/storage/' .
                                                                    $pengajuan->file_konversi[0]->path .
                                                                    '/' .
                                                                    $pengajuan->file_konversi[0]->name_random }}"
                                                                    href="#" type="button"
                                                                    class="btn_view_file btn btn-default btn-sm">
                                                                    <i class="far fa-eye"></i> Lihat
                                                                    File
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </div>
                                    <div class="card-footer">
                                        {!! $view_aksi !!}
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title font-weight-bold">Histori Pengajuan Berkas</h5>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="timeline modal_content_histori">
                                            {{-- List data histori pegajuan --}}
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <div class="overlay loading_histori">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @include('pengajuan.modal-view-file')
    @include('pengajuan.modal-teruskan')
    @include('pengajuan.modal-selesai')
    @include('pengajuan.modal-tolak')
    @include('pengajuan.modal-verifikasi-data')
@endsection
@push('js')
    <script src="{{ asset('plugins/bootbox/bootbox.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.btn_view_file').click(function(e) {
                e.preventDefault();
                let url = $(this).attr('data-url');
                viewFile(url);
            });

            function viewFile(url) {
                const width = 800
                const height = 700
                const pos = {
                    x: (screen.width / 2) - (width / 2),
                    y: (screen.height / 2) - (height / 2)
                };
                const features = `width=${width} height=${height} left=${pos.x} top=${pos.y}`;
                return window.open(url, '_blank', features).focus();
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#btn_teruskan").click(function() {
                $('#modal_teruskan').modal('show')
            });
            $("#btn_selesai").click(function() {
                $('#modal_selesai').modal('show')
            });
            $("#btn_tolak").click(function() {
                $('#modal_tolak').modal('show')
            });
            $("#btn_verifikasi").click(function() {
                $('#modal_verifikasi').modal('show')
                let nip = $('#nip').text()
                $.ajax({
                    url: `{{ url('admin/pegawai/verifikasi/pelanggaran/${nip}') }}`,
                    type: 'GET',
                    success: function(json) {
                        console.log(json)
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert("Gagal Verifikasi Data, silahkan coba lagi ...")
                    }
                })
            });

            $.ajax({
                url: @json(route('pengajuan.histori', $pengajuan->uuid)),
                type: 'GET',
                success: function(json) {
                    $('.loading_histori').hide()

                    json.data.histori.forEach($item => {
                        let data_tracking = '';
                        switch ($item.aksi.status) {
                            case 'meneruskan':
                                data_tracking =
                                    `<a href="#"> ${$item.pengirim_nama}</a> ${$item.aksi.pesan}  <a href="#"> ${$item.penerima_nama}</a>`
                                break;
                            case 'proses_surat':
                                data_tracking =
                                    `<a href="#"> ${$item.penerima_nama}</a> ${$item.aksi.pesan}`
                                break;
                            case 'selesai':
                                data_tracking =
                                    `${$item.aksi.pesan}  <a href="#"> ${$item.penerima_nama}</a>`
                                break;
                            case 'tolak':
                                data_tracking =
                                    `<a href="#"> ${$item.pengirim_nama}</a> ${$item.aksi.pesan} <div style="margin-top:10px" class="alert alert-secondary alert-dismissible">
                                  
                                    ${$item.pesan}
                                    </div>`
                                break;
                            default:
                                data_tracking =
                                    `<a href="#"> ${$item.pengirim_nama}</a> ${$item.aksi.pesan}`
                        }
                        $(".modal_content_histori").append(
                            `<div>
                           <i style="color: white !important" class="${$item.aksi.icon}"></i>
                           <div class="timeline-item">
                              <div class="timeline-body">
                                    ${data_tracking} 
                                     
                              </div>
                              <div class="dropdown-divider"></div>
                              <div class="timeline-footer">
                                 <span class="time"><i class="fas fa-clock"></i> ${$item.tgl_kirim} </span>
                              </div>
                           </div>
                        </div>`);
                    });
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert("Gagal Mengambil data histori, silahkan coba lagi ...")
                }
            })

        });

        $('.select2bs4').select2({
            theme: 'bootstrap4',
        })
        $('.horizontalLine').css({
            left: $('.timeline-badge').first().position().left,
            width: $('.timeline-item-last').position().left
        });
    </script>
@endpush
