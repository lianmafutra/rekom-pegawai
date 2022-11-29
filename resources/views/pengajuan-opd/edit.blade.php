@extends('admin.layouts.master')
@push('css')
    <link href="{{ URL::asset('plugins/filepond/filepond.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('plugins/filepond/filepond-plugin-image-preview.css') }} " rel="stylesheet" />
@endpush
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Pengajuan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pengajuan</li>
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
                                    <div class="col-md-6 card-body">
                                        <form name="pengajuan" action="{{ route('pengajuan.store') }}" method="POST"
                                            autocomplete="off" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')

                                            <div class="form-group">
                                                <label>Nama Pegawai</label>
                                                <input autocomplete="off" type="text" class="form-control" name="nama"
                                                    placeholder="Nama Pegawai" value="{{ $pengajuan->nama }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">NIP</label>
                                                <input type="text" class="form-control" name="nip"
                                                    placeholder="NIP Pegawai" value="{{ $pengajuan->nip }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Catatan Tambahan</label>
                                                <textarea class="form-control" rows="3" placeholder="Tuliskan Catatan Tambahan (Opsional)">{{ $pengajuan->catatan }}</textarea>
                                            </div>
                                            <div class="form-group ">
                                                <label>File SK PNS</label>
                                                <input required type="file" data-max-file-size="5 MB" class="filepond"
                                                    accept="{{ config('upload.pengajuan.filetype') }}" name="file_sk_pns"
                                                    placeholder="File SK PNS">
                                            </div>
                                            <div class="form-group ">
                                                <label>File SK CPNS</label>
                                                <input required type="file" data-max-file-size="5 MB" class="filepond"
                                                    accept="{{ config('upload.pengajuan.filetype') }}" name="file_sk_cpns"
                                                    placeholder="File SK CPNS">
                                            </div>
                                            <div class="form-group ">
                                                <label>File SK Jabatan</label>
                                                <input required type="file" data-max-file-size="5 MB" class="filepond"
                                                    accept="{{ config('upload.pengajuan.filetype') }}"
                                                    name="file_sk_jabatan" placeholder="File SK Jabatan">
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
    <script src="{{ URL::asset('plugins/filepond/filepond.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-metadata.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-encode.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-validate-size.js') }} "></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            FilePond.registerPlugin(
                FilePondPluginFileMetadata,
                FilePondPluginFileEncode,
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize);

            const inputElements = document.querySelectorAll('input.filepond');
            const pond = FilePond.create(
                document.querySelector('input.filepond'), {
                    storeAsFile: true,
                    files: cups,
                    source: "/uploads/"
                }
            );

            
        });
     

        function myFunction() {
            $('body').on('click', '.filepond--item', function(e) {
                let name = $(this).find("legend").html()
                let ext = name.toLowerCase().split('.').pop();
                if (ext == "docx" || ext == "doc" || ext == "xls" || ext == "xlsx" || ext == "ppt" || ext ==
                    "pptx") {
                    window.open("https://view.officeapps.live.com/op/view.aspx?src=" + window.location.origin +
                        "/uploads/" + name, '_blank');
                } else {
                    window.open(window.location.origin + "/uploads/" + name, '_blank');
                }
            });
        }

        $("form[name='pengajuan']").validate({
            rules: {
                nama: "required",
                nip: {
                    required: true
                },
                file_sk_cpns: 'required'

            },

            messages: {
                nama: "Nama Wajib Di isi",
                nip: "NIP Pegawai Wajib di isi",

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
    </script>
@endpush
