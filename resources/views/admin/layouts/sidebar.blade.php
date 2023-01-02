<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('img/logo_kota.png') }}" alt="{{ Setting::getName('app_name') }}"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ Setting::getValue('app_short_name') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact"
                data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>@php $i = 1; @endphp
                @canany(['read user', 'read role', 'read permission'])
                    <li class="nav-header ml-2">ACCESS</li>
                @endcanany
                @can('read user')
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}"
                            class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">
                            <i class="fas fa-user nav-icon"></i>
                            <p>User</p>
                        </a>
                    </li>
                @endcan
                @can('read role')
                    <li class="nav-item">
                        <a href="{{ route('role.index') }}"
                            class="nav-link {{ request()->routeIs('role.index') ? 'active' : '' }}">
                            <i class="fas fa-user-cog nav-icon"></i>
                            <p>Role</p>
                        </a>
                    </li>
                @endcan
                @can('read permission')
                    <li class="nav-item">
                        <a href="{{ route('permission.index') }}"
                            class="nav-link {{ request()->routeIs('permission.index') ? 'active' : '' }}">
                            <i class="fas fa-unlock nav-icon"></i>
                            <p>Permission</p>
                        </a>
                    </li>
                @endcan
                @can('read setting')
                    <li class="nav-header ml-2">SETTINGS</li>
                    <li class="nav-item">
                        <a href="{{ route('setting.index') }}"
                            class="nav-link {{ request()->routeIs('setting.index') ? 'active' : '' }}">
                            <i class="fas fa-cog nav-icon"></i>
                            <p>Setting</p>
                        </a>
                    </li>
                @endcan
                @can('filemanager')
                    <li class="nav-item">
                        <a href="{{ route('filemanager') }}"
                            class="nav-link {{ request()->routeIs('filemanager') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-folder"></i>
                            <p>File Manager</p>
                        </a>
                    </li>
                @endcan
                @can('pengajuan menu')
                    <li class="nav-item">
                        @can('pengajuan verifikasi index')
                            {{-- <a href="{{ route('pengajuan.verifikasi.index') }}"
                                class="nav-link {{ request()->routeIs('pengajuan*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>Data Pengajuan</p>
                                @if ($global_jumlah_notif)
                                    <span style="margin-right: 36px !important" class="badge badge-info right">{{ $global_jumlah_notif }}</span>
                                @endif
                            </a> --}}

                        <li class="nav-item menu-is-opening menu-open">
                            <a href=""
                                class="nav-link {{ request()->routeIs('pengajuan*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>Data Pengajuan</p>
                                <i class="right fas fa-angle-left"></i>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pengajuan.verifikasi.index', 'status=belum-direspon') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Belum Direspon </p>
                                        @if ($global_jumlah_notif)
                                        <span style="margin-right: 36px !important" class="badge badge-info right">{{ $global_jumlah_notif }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pengajuan.verifikasi.index', 'status=semua') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Semua Pengajuan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @can('pengajuan index')
                        <a href="{{ route('pengajuan.index') }}"
                            class="nav-link {{ request()->routeIs('pengajuan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-folder"></i>
                            <p>Pengajuan</p>
                            @if ($global_jumlah_notif)
                                <span class="badge badge-info right">{{ $global_jumlah_notif }}</span>
                            @endif
                        </a>
                    @endcan
                    </li>
                @endcan
                @can('master rekom pegawai')
                    <li class="nav-item">
                        <a href="{{ route('master-rekom.index') }}"
                            class="nav-link {{ request()->routeIs('master-rekom*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p> Master Rekom</p>
                        </a>
                    </li>
                @endcan
                @can('master user')
                    <li class="nav-item">
                        <a href="{{ route('master-user.index') }}"
                            class="nav-link {{ request()->routeIs('master-user*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p> Master User </p>
                        </a>
                    </li>
                @endcan
                @can('profile menu')
                    <li class="nav-item">
                        <a href="{{ route('profile.index') }}"
                            class="nav-link {{ request()->routeIs('profil*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profil</p>
                        </a>
                    </li>
                @endcan
                {{-- <li class="nav-header"></li>
                <li class="nav-item">
                <a href="#" class="nav-link bg-danger" data-toggle="modal" data-target="#modal-logout" data-backdrop="static" data-keyboard="false">
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                    <p>KELUAR</p>
                </a>
                </li> --}}
                <li class="nav-header"></li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
