@extends('admin.layouts.master')
@push('css')
    <link href="{{ URL::asset('plugins/filepond/filepond.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('plugins/filepond/filepond-plugin-image-preview.css') }} " rel="stylesheet" />
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                         
                                    <img class="profile-user-img img-fluid img-circle" src="{{ $user->foto_url }}"
                                        alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                                <p class="text-muted text-center">{{ $user->roles->pluck('name')[0] }}</p>
                                <div class="form-group row">
                                    <div class="text-center col-sm-12">
                                        <button class="btn_upload_foto btn btn-secondary btn-sm"> <i
                                                class="fas fa-upload"></i> Ubah Foto</button>
                                    </div>
                                </div>
                                {{-- <p class="text-muted text-center">Last Login : </p> --}}
                                {{-- <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Followers</b> <a class="float-right">1,322</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Following</b> <a class="float-right">543</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Friends</b> <a class="float-right">13,287</a>
                                    </li>
                                </ul> --}}
                                {{-- <a href="#" class="btn btn-primary btn-block"><b></b></a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#profile"
                                            data-toggle="tab">Profile</a></li>
                                    <li class="nav-item"><a class="nav-link " href="#settings"
                                            data-toggle="tab">Settings</a></li>
                                    <li class="nav-item"><a class="nav-link " href="#settings"
                                            data-toggle="tab">Activity</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="profile">
                                        <form class="form-horizontal">
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nama"
                                                        value="{{ $user->name }}" placeholder="Nama">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Username</label>
                                                <div class="col-sm-10">
                                                    <input disabled type="email" class="form-control" id="username"
                                                        placeholder="Username" value="{{ $user->username }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Role</label>
                                                <div class="col-sm-10">
                                                    <input disabled type="text" class="form-control" id="role"
                                                        placeholder="Username"
                                                        value="{{ $user->roles->pluck('name')[0] }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Nomor HP</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="kontak"
                                                        placeholder="Nomor Handphone" value="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class=" tab-pane" id="activity">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modal_upload_foto">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload Foto Profil</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ">

                        <input required type="file" data-max-file-size="5 MB" class="filepond" accept="image/*"
                            name="foto_profil">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Lanjutkan</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ URL::asset('plugins/filepond/filepond.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-metadata.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-encode.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-file-validate-size.js') }} "></script>
    <script src="{{ URL::asset('plugins/filepond/filepond-plugin-image-preview.js') }}"></script>

    <script>
        $(".btn_upload_foto").click(function() {
            $('#modal_upload_foto').modal('show')
        });

        FilePond.registerPlugin(
            FilePondPluginFileMetadata,
            FilePondPluginFileEncode,
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize);
        const inputElements = document.querySelectorAll('input.filepond');
        Array.from(inputElements).forEach(inputElement => {
            FilePond.create(inputElement, {
                storeAsFile: true,
                labelIdle: `Upload File Foto <span class="filepond--label-action">Browse</span>`,
                imageCropAspectRatio: '1:1',
                allowImagePreview: true,
                imagePreviewHeight: 300,
                imagePreviewWidth: 300,


            });
        });
    </script>
@endpush
