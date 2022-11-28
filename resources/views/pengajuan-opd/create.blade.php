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

        .profile-custom  {
            border: 1px solid #adb5bd !important;
            margin: 0 auto;
            border-radius: 10%;
            background-position: center center;
            background-repeat: no-repeat;
            width: 250px;
            height: 250px;
             !important;
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
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="col-md-6 card-body">
                                            <form name="pengajuan" action="{{ route('pengajuan.store') }}" method="POST"
                                                autocomplete="off" enctype="multipart/form-data">
                                                @csrf
                                                @method('POST')
                                                <div class="form-group">
                                                    <label>Nama Pegawai<span style="color: red">*</span></label>
                                                    <select name="pegawai" required type=""
                                                        class="select2-pegawai form-control select2bs4"
                                                        data-placeholder="-- Pilih Pegawai --" style="width: 100%;">
                                                        <option></option>
                                                        @foreach ($pegawai as $item => $key)
                                                            <option value="{{ $key['nipbaru'] }}"> {{ $key['nama'] }} (
                                                                {{ $key['nipbaru'] }} )</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nomor Surat Pengantar</label>
                                                    <input type="text" class="form-control" name="nomor_surat"
                                                        placeholder="Nomor Surat Pengantar" value="">
                                                </div>
                                                <div class="form-group">
                                                    <div class="bd-highlight">
                                                        <label>Tanggal Surat Pengantar <span
                                                                style="color: red">*</span></label>
                                                        <div style="padding: 0 !important; width: 100%"
                                                            class="input-group ">
                                                            <input required autocomplete="off" name="tgl_pengantar"
                                                                class="form-control tanggal" type="text"
                                                                placeholder="Hari/Bulan/Tahun" data-input>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis Rekomendasi<span style="color: red">*</span></label>
                                                    <select name="rekomendasi" required type=""
                                                        class="select2-jenis form-control select2bs4"
                                                        data-placeholder="-- Pilih Jenis Rekomendasi --"
                                                        style="width: 100%;">
                                                        <option></option>
                                                        <option>Bebas Hukuman Disiplin</option>
                                                        <option>Bebas Temuan</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Catatan Tambahan</label>
                                                    <textarea class="form-control" rows="3" placeholder="Tuliskan Catatan Tambahan (Opsional)"></textarea>
                                                </div>
                                                <div class="form-group ">
                                                    <label>File SK Pangkat Terakhir</label>
                                                    <input required type="file" data-max-file-size="5 MB"
                                                        class="filepond" accept="{{ config('upload.pengajuan.filetype') }}"
                                                        name="file_sk_pns" placeholder="File SK PNS">
                                                </div>
                                                <div class="form-group ">
                                                    <label>File Surat Pengantar kepala OPD </label>
                                                    <input required type="file" data-max-file-size="5 MB"
                                                        class="filepond" accept="{{ config('upload.pengajuan.filetype') }}"
                                                        name="file_sk_cpns" placeholder="File SK CPNS">
                                                </div>
                                                <div class="form-group ">
                                                    <label>Konversi NIP (Optional)</label>
                                                    <input required type="file" data-max-file-size="5 MB"
                                                        class="filepond" accept="{{ config('upload.pengajuan.filetype') }}"
                                                        name="file_sk_jabatan" placeholder="File SK Jabatan">
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
                                                            src="{{ asset('img/avatar.png') }}"
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
                                        <button type="submit" class="btn btn-primary">Submit Berkas</button>
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
    @include('pengajuan-opd.modal-view-file')
@endsection
@push('js')
    <script src="{{ asset('plugins/flatpicker/flatpickr.min.js') }}"></script>
    <script src="{{ asset('plugins/flatpicker/id.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-metadata.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-encode.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-validate-size.js') }} "></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                allowClear: true
            })
            $('.select2-pegawai').change(function() {
                $('.loading').css('display', 'block')
                $('.profile_data').css('display', 'none')

                let nip = $(this).val();
                $.ajax({
                    url: `{{ url('admin/pegawai/${nip}') }}`,
                    type: 'GET',
                    tryCount: 0,
                    retryLimit: 3,
                    success: function(json) {
                        $('.profile-user-img').attr("src",
                            "https://bkd.jambikota.go.id/simpeg/photo/" + json.photo);
                        $('.nama').html(json.nama ? json.nama : '-')
                        $('.nip').html(json.nipbaru)
                        $('.pangkat').html(json.pangkat)
                        $('.jabatan').html(json.njab)
                        $('.opd').html(json.nunker)
                        $(".loading").fadeOut(1000);
                        $(".profile_data").fadeIn(1100);

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert("Gagal Mengambil data pegawai, silahkan coba lagi ...")
                    }
                });
            });
            FilePond.registerPlugin(
                FilePondPluginFileMetadata,
                FilePondPluginFileEncode,
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize);
            const inputElements = document.querySelectorAll('input.filepond');
            Array.from(inputElements).forEach(inputElement => {
                FilePond.create(inputElement, {
                    storeAsFile: true,
                    instantUpload: false,
                    allowProcess: false
                });
            });
        });
        $("form[name='pengajuan']").validate({
            rules: {
                pegawai: "required",
                rekomendasi: "required",
                file_sk_cpns: 'required'
            },
            messages: {
                pegawai: "Nama Wajib Di isi",
                rekomendasi: "Jenis RekomendasiNama Wajib Di isi",
            },
            errorElement: 'div',
            errorClass: "invalid-feedback",
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).parents("div.control-group").addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents(".invalid-feedback").removeClass(errorClass).addClass(validClass);
            }
        });

        flatpickr(".tanggal", {
            allowInput: true,
            dateFormat: "d-m-Y",
            locale: "id",

        });
    </script>
@endpush
