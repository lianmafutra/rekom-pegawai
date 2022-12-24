<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title . ' - ' . Setting::getValue('app_name') }}</title>
    <link rel="icon" href="{{ asset(Setting::getValue('app_favicon')) }}" type="image/png" />

    <link rel="stylesheet" href="{{ asset('template/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/admin/dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css">
    

    @stack('style')
    @stack('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
   
    <div class="wrapper">

        <!-- Navbar -->
     
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
     

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->
      
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('template/admin/plugins/jquery/jquery.min.js') }}"></script>
    @yield('js')
    @stack('js')
    @include('admin.layouts.script')
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('template/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('template/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('template/admin/dist/js/adminlte.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2-min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        if (@json(Session::has('success'))) {
            Toast.fire({
                icon: 'success',
                title: @json(Session::get('success'))
            })
        }

        if (@json(Session::has('success-modal'))) {
            Swal.fire({
                icon: 'success',
                title: @json(Session::get('success-modal.title')),
                html: @json(Session::get('success-modal.message')),
                showCancelButton: true,
                allowEscapeKey: false,
                showCancelButton: false,
                allowOutsideClick: false,
            })
        }

        if (@json(Session::has('error-modal'))) {
            Swal.fire({
                icon: 'error',
                title: @json(Session::get('success-modal.title')),
                html: @json(Session::get('success-modal.message')),
                showCancelButton: true,
                allowEscapeKey: false,
                showCancelButton: false,
                allowOutsideClick: false,
            })
        }

        if (@json(Session::has('error'))) {
            Toast.fire({
                icon: 'error',
                title: @json(Session::get('error'))
            })
        }


        $("form[name='ubah-password']").validate({
            rules: {
                password: "required",
                password_baru: {
                    required: true,
                    minlength: 6,
                },

                password_konfirmasi: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password_baru"
                }
            },

            messages: {
                password: "Password Lama Wajib Di isi",
                password_baru: {
                    minlength: "Minimal Password 6 karakter",
                    required: "Password Baru Wajib Di isi",
                },
                password_konfirmasi: {
                    minlength: "Minimal Password 6 karakter",
                    required: "Password Konfirmasi Wajib Di isi",
                    equalTo: "Password Konfirmasi harus sama dengan password baru"
                }
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
    @stack('script')
</body>

</html>
