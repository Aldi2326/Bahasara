<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Myrathemes" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/bahasara-logo.png') }}">

    <!-- Icons css  (Mandatory in All Pages) -->
    <link href="{{ asset('assets/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css">

    <!-- App css  (Mandatory in All Pages) -->
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="wrapper">
        <!-- Start Sidebar -->
        @include('partials.admin.sidebar')
        <!-- End Sidebar -->

        <!-- Start Page Content here -->
        <div class="page-content">

            <!-- Topbar Start -->
            @include('partials.admin.header')
            <!-- Topbar End -->

            <main>

                <!-- Page Title Start -->
                @yield('content')
                <!-- Page Title End -->
            </main>

            <!-- Footer Start -->
            @include('partials.admin.footer')
            
            <!-- Footer End -->

        </div>
        <!-- End Page content -->

    </div>

    <!-- Plugin Js (Mandatory in All Pages) -->
    <script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/preline/preline.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/iconify-icon/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>

    <!-- App Js (Mandatory in All Pages) -->
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>

    <!-- Apexcharts js -->
    <script src="{{ asset('assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Morris Js Chart -->
    <script src="{{ asset('assets/admin/libs/morris.js/morris.min.js') }}"></script>

    <script src="{{ asset('assets/admin/libs/raphael/raphael.min.js') }}"></script>

    <!-- Dashboard Project Page js -->
    <script src="{{ asset('assets/admin/js/pages/dashboard.js') }}"></script>

</body>

</html>