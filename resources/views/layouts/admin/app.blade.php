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
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- App css  (Mandatory in All Pages) -->
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Bootstrap Icons CDN -->
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
                @if (session('success'))
                    <div id="toast-success" class="toast-custom">
                        <span>{{ session('success') }}</span>
                        <span class="toast-close" onclick="closeToast()">×</span>
                    </div>

                    <script>
                        // Hilang otomatis setelah 3 detik
                        setTimeout(() => {
                            closeToast();
                        }, 3000);

                        function closeToast() {
                            const toast = document.getElementById('toast-success');
                            if (toast) {
                                toast.style.opacity = '0'; // efek fade out
                                setTimeout(() => toast.remove(), 500); // hapus elemen setelah animasi
                            }
                        }
                    </script>

                    <style>
                        .toast-custom {
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            min-width: 250px;
                            max-width: 350px;
                            background-color: #28a745;
                            /* hijau sukses */
                            color: white;
                            padding: 12px 16px;
                            border-radius: 8px;
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            gap: 10px;
                            z-index: 9999;
                            transition: opacity 0.5s ease;
                        }

                        .toast-close {
                            cursor: pointer;
                            font-size: 18px;
                            font-weight: bold;
                        }

                        .toast-close:hover {
                            color: #ddd;
                        }
                    </style>
                @endif
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
