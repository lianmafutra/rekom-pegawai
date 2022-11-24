@extends('admin.layouts.master')
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
                    <div class="col-md-6">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">

                                    <img class="profile-user-img img-fluid img-circle" src="{{ $user->foto_url }}"
                                        alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                                <p class="text-muted text-center">{{ $user->roles->pluck('name')[0] }}</p>
                                <p class="text-muted text-center">Last Login : </p>
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
                    <div class="col-md-3">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Setting</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            
                              
                            </div>
                            <div class="card-body box-profile">
                              <ul class="list-group list-group mb-3">
                                 <li class="list-group-item">
                                    <a href="#" class="pl-3 btn btn-primary btn-block text-left">  <i class="nav-icon fas fa-folder"></i>  Ubah Foto</a>
                                 </li>
                                 <li class="list-group-item">
                                    <a href="#" class="pl-3 btn btn-primary btn-block text-left">  <i class="nav-icon fas fa-folder"></i>  Ubah Data Profile</a>
                                 </li>
                                 <li class="list-group-item">
                                    <a href="#" class="pl-3 btn btn-primary btn-block text-left">  <i class="nav-icon fas fa-folder"></i>  Ubah Password</a>
                                 </li>
                             </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
