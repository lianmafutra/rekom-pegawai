@extends('admin.layouts.master')
@push('css')
    <link href="{{ URL::asset('plugins/filepond/filepond.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('plugins/filepond/filepond-plugin-image-preview.css') }} " rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/flatpicker/flatpickr.min.css') }}">
@endpush
@section('content')
    <style>
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
        .filepond--file {
            background: #28a745;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Buat Pengajuan Rekomendasi</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                {{-- @if ($errors->has('file_sk'))
                                    <span class="invalid">{{ $errors->first('file_sk') }}</span>
                                @endif --}}
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="col-md-6 card-body">
                                            <form id="form_pengajuan" name="form_pengajuan" method="POST"
                                                autocomplete="off" enctype="multipart/form-data">
                                                @csrf
                                                @method('POST')
                                                <div class="form-group">
                                                    <label>Nama Pegawai<span style="color: red">*</span></label>
                                                    <select id="pegawai" name="pegawai" required type=""
                                                        class="select2 select2-pegawai form-control select2bs4"
                                                        data-placeholder="-- Pilih Pegawai --" style="width: 100%;">
                                                        <option></option>
                                                       
                                                        @foreach ($pegawai as $item => $key)
                                                            <option value="{{ $key['nipbaru'] }}"> {{ $key['nama'] }} (
                                                                {{ $key['nipbaru'] }} )</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text pegawai_err"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nomor Surat Pengantar <span style="color: red">*</span></label>
                                                    <input id="nomor_pengantar" type="text" class="form-control"
                                                        name="nomor_pengantar" placeholder="Nomor Surat Pengantar"
                                                        value="">
                                                        <span class="text-danger error-text nomor_pengantar_err"></span>
                                                </div>
                                                <div class="form-group">
                                                    <input hidden name="penerima_uuid"
                                                        value="26cabc5d-7c32-4e97-83f0-a02a226783c5">
                                                </div>
                                                <div class="form-group">
                                                    <div class="bd-highlight">
                                                        <label>Tanggal Surat Pengantar <span
                                                                style="color: red">*</span></label>
                                                        <div style="padding: 0 !important; width: 100%"
                                                            class="input-group ">
                                                            <input style="width: 90%" id="tgl_pengantar" required
                                                                autocomplete="off" name="tgl_pengantar"
                                                                class="form-control tanggal" type="text"
                                                                placeholder="Hari/Bulan/Tahun" data-input>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger error-text tgl_pengantar_err"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis Rekomendasi<span style="color: red">*</span></label>
                                                    <select id="rekom_jenis" name="rekom_jenis" required type=""
                                                        class="select2 form-control select2bs4"
                                                        data-placeholder="-- Pilih Jenis Rekomendasi --"
                                                        style="width: 100%;">
                                                        <option></option>
                                                        @foreach ($rekom_jenis as $key => $item)
                                                            <option value="{{ $key }}">{{ $item }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text rekom_jenis_err"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Keperluan Rekomendasi<span style="color: red">*</span></label>
                                                    <select id="keperluan_id" name="keperluan_id" required type=""
                                                        class="select2 form-control select2bs4"
                                                        data-placeholder="-- Pilih Jenis Keperluan --" style="width: 100%;">
                                                        <option></option>
                                                        @foreach ($keperluan as $item)
                                                            <option value="{{ $item->id }}">{{ $item->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger error-text keperluan_id_err"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Catatan Tambahan</label>
                                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Tuliskan Catatan Tambahan (Opsional)"></textarea>
                                                </div>
                                                <label>File SK Pangkat Terakhir<span style="color: red">*</span></label>
                                                <input id="file_sk" type="file" data-max-file-size="5 MB"
                                                    class="filepond " accept="{{ config('upload.pengajuan.filetype') }}"
                                                    name="file_sk" placeholder="File SK PNS">
                                                    <span class="text-danger error-text file_sk_err"></span>
                                                <div class="form-group ">
                                                </div>
                                                <div class="form-group ">
                                                    <label>File Surat Pengantar kepala OPD <span
                                                            style="color: red">*</span></label>
                                                    <input id="file_pengantar_opd" type="file"
                                                        data-max-file-size="5 MB" class="filepond"
                                                        accept="{{ config('upload.pengajuan.filetype') }}"
                                                        name="file_pengantar_opd" placeholder="File Pengantar OPD">
                                                        <span class="text-danger error-text file_pengantar_opd_err"></span>
                                                </div>
                                                <div class="form-group ">
                                                    <label>Konversi NIP (Optional)</label>
                                                    <input id="file_konversi_nip" required type="file"
                                                        data-max-file-size="5 MB" class="filepond"
                                                        accept="{{ config('upload.pengajuan.filetype') }}"
                                                        name="file_konversi_nip" placeholder="File Konversi NIP">
                                                        <span class="text-danger error-text file_konversi_nip_err"></span>
                                                </div>
                                        </div>
                                        <div style="margin-left: 10px;" class="col-md-5 card ">
                                            <div class="card-header">
                                                <h6>Detail Pegawai</h6>
                                            </div>
                                            <div class="card-body box-profile">
                                                <img class="loading loading-custom" src="{{ asset('img/loading.gif') }}">
                                                <div class="profile_data">
                                                    <div class="text-center">
                                                        <img class="profile-user-img profile-custom  img-fluid img-circle"
                                                            src="{{ asset('img/avatar2.png') }}"
                                                            alt="User profile picture">
                                                    </div>
                                                    <ul class="list-group list-group-unbordered mb-3 mt-3">
                                                        <li class="list-group-item">
                                                            <b>Nama Lengkap : </b> <a class="float-right nama"></a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>NIP : </b> <a class="float-right nip"></a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>Pangkat/Gol : </b> <a class="float-right pangkat"></a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>Jabatan : </b> <a class="float-right jabatan"></a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>OPD : </b> <a class="float-right opd"></a>
                                                        </li>
                                                        <div class="info-data-api profile_data"
                                                            style="display: none; font-style: italic; padding : 20px 0 0 0">
                                                            <span>Data Sinkron dari Dinas BKPSDMD ( 10-12-2022 10:09 ),
                                                                Apabila ada data pegawai yang tidak sesuai silahkan
                                                                menghubungi Dinas Komunikasi & Informatika Kota Jambi</span>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" id="btn_submit" class="btn btn-primary">Submit
                                            Berkas</button>
                                    </div>
                                    </form>
                                </div>
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
@endsection
@push('js')
    <script src="{{ asset('plugins/flatpicker/flatpickr.min.js') }}"></script>
    <script src="{{ asset('plugins/flatpicker/id.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-metadata.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-encode.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-validate-size.js') }} "></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bootbox/bootbox.min.js') }}"></script>
    <script src="https://unpkg.com/just-validate@3.8.1/dist/just-validate.production.min.js"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2-min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#btn_submit").click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Pengajuan',
                    text: 'Apakah anda yakin ingin melanjutkan pengajuan berkas rekomendasi ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Lanjutkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#form_pengajuan").submit();
                        // var formdata = $('#form_pengajuan').serialize();
                    }
                })
            });
            $("#form_pengajuan").submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: @json(route('pengajuan.store')),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Mengirim Data...',
                            html: 'Mohon TUnggu...',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success: (response) => {
                        if (response) {
                            this.reset()
                            Swal.fire(
                                'Good job!',
                                'You clicked the button!',
                                'success'
                            )
                            swal.hideLoading()
                        }
                    },
                    error: function(response) {
                     printErrorMsg(response.responseJSON.errors);
                     console.log(response.responseJSON.errors)
                        Swal.fire({
                            title: 'Oops...',
                            text: response.responseJSON
                                .message,
                        })
                        // console.log(response.responseJSON
                        //     .message)
                    }
                });
            });
            function printErrorMsg(msg) {
               console.log('print error')
                $.each(msg, function(key, value) {
                    console.log(key);
                    $('.' + key + '_err').text(value);
                });
            }
            // select2
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                //  allowClear: true
            })
            // select2 validation
            $('.select2').change(function() {
                $(this).closest("div").find('.just-validate-error-label').remove()
            })
            $('.select2-pegawai').change(function() {
                $('.profile-user-img').attr("src", "");
                $('.loading').css('display', 'block')
                $('.profile_data').css('display', 'none')
                let nip = $(this).val();
                $.ajax({
                    url: `{{ url('admin/pegawai/${nip}') }}`,
                    type: 'GET',
                    tryCount: 0,
                    retryLimit: 3,
                    success: function(json) {
                        $(".profile_data").fadeIn(1100);
                        $('.profile-user-img').attr("src", @json($url_foto) + json
                            .photo);
                        $('.nama').html(json.nama ? json.nama : '-')
                        $('.nip').html(json.nipbaru)
                        $('.pangkat').html(json.pangkat)
                        $('.jabatan').html(json.njab)
                        $('.opd').html(json.nunker)
                        $(".loading").fadeOut(1000);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert("Gagal Mengambil data pegawai, silahkan coba lagi ...")
                    }
                });
            });
            // Filepond
            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize);
            const file_sk = FilePond.create(document.querySelector('#file_sk'));
            const file_pengantar = FilePond.create(document.querySelector('#file_pengantar_opd'));
            const file_konversi_nip = FilePond.create(document.querySelector('#file_konversi_nip'));
            file_sk.setOptions({
                storeAsFile: true,
            });
            file_pengantar.setOptions({
                storeAsFile: true,
            });
            file_konversi_nip.setOptions({
                storeAsFile: true,
            });
            flatpickr(".tanggal", {
                allowInput: true,
                dateFormat: "d-m-Y",
                locale: "id",
            });
        });
    </script>
@endpush
