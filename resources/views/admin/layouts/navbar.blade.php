<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">{{ Setting::getValue('app_name') }}</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" id="btntheme" role="button">
                <i id="icontheme" class="fas fa-sun"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('index') }}" target="_bkank" role="button">
                <i class="fas fa-globe"></i>
            </a>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('template/admin/dist/img/user2-160x160.jpg') }}"
                    class="user-image img-circle elevation-2" alt="User Image">
                {{-- <span class="d-none d-md-inline">{{ Auth::user()->name }}</span> --}}
            </a>

            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">

                {{-- <li class="user-footer">
                  <a href="#" class="btn btn-default">Profile</a>
                  <a href="#" data-toggle="modal" data-target="#modal-logout" data-backdrop="static" data-keyboard="false" class="btn btn-danger float-right">Keluar</a>
              </li> --}}
                <span 
                    class="dropdown-item dropdown-header">
                    <span  class="d-none d-md-inline">{{ Auth::user()->name }}</span></span>
                <div class="dropdown-divider"></div>

                {{-- <span class="dropdown-item dropdown-header">15 Notifications</span> --}}
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i>Profile

                </a>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i>Ubah Password
                </a>

                <div class="dropdown-divider"></div>
                <a  data-toggle="modal" data-target="#modal-logout" data-backdrop="static" data-keyboard="false" style="padding-bottom: 15px" href="#" class="dropdown-item">
                    <i class="fas fa-sign-out-alt  mr-2"></i> Logout
                </a>

            </div>
        </li>

    </ul>
</nav>
