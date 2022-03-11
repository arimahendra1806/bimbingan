<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Bimbingan Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('vendor/minia') }}/assets/images/favicon.ico">

    <!-- DataTables -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/minia') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link
        href="{{ asset('vendor/minia') }}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Sweet Alert-->
    <link href="{{ asset('vendor/minia') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('vendor/minia') }}/assets/css/fontawesome.v5.10.0.css" rel="stylesheet" type="text/css" />

    <!-- plugin css -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css"
        rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('vendor/minia') }}/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('vendor/minia') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('vendor/minia') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('vendor/minia') }}/assets/css/app.min.css" id="app-style" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('vendor/minia') }}/assets/css/custom.css" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Topbar -->
        @include('layouts.minia.topbar')
        <!-- END Topbar -->

        <!-- Sidebar -->
        @include('layouts.minia.sidebar')
        <!-- END Sidebar -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <!-- ========== Page-content Start ========== -->
            <div class="page-content">
                <!-- Content -->
                @yield('content')
                <!-- End Content -->
            </div>
            <!-- Page-content End -->

            <!-- Footer -->
            @include('layouts.minia.footer')
            <!-- END Footer -->

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Rightbar -->
    @include('layouts.minia.rightbar')
    <!-- END Rightbar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/jquery/jquery.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/feather-icons/feather.min.js"></script>
    <!-- pace js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/pace-js/pace.min.js"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>

    <script src="{{ asset('vendor/minia') }}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js">
    </script>

    <!-- Responsive examples -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js">
    </script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js">
    </script>

    <!-- Datatable init js -->
    <script src="{{ asset('vendor/minia') }}/assets/js/pages/datatables.init.js"></script>

    <!-- Plugins js-->
    <script
        src="{{ asset('vendor/minia') }}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js">
    </script>
    <script
        src="{{ asset('vendor/minia') }}/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js">
    </script>

    <script src="{{ asset('vendor/minia') }}/assets/js/app.js"></script>

    @yield('js')

</body>

</html>
