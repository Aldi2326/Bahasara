<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Myrathemes" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo-icon.png') }}">

    <!-- Icons css  (Mandatory in All Pages) -->
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- App css  (Mandatory in All Pages) -->
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('assets/admin/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@4.1.4/css/froala_editor.pkgd.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@4.1.4/css/froala_style.min.css">
    <style>
        /* 🔹 Aktifkan kembali style default untuk list */
        .prose ul,
        .prose ol {
            all: revert;
        }

        /* 🔹 Supaya bullet/number juga muncul dalam hasil dari Froala */
        .fr-view ul,
        .fr-view ol {
            all: revert;
        }
    </style>
    {{-- ======== Leaflet Map Script ======== --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    {{-- ======== SweetAlert2 ======== --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    <!-- Inisialisasi Editor -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new FroalaEditor('#froala-editor', {
                height: 400,

                // 🔹 Semua toolbar Froala
                toolbarButtons: {
                    moreText: {
                        buttons: [
                            'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript',
                            'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass',
                            'inlineStyle', 'clearFormatting'
                        ],
                        align: 'left',
                        buttonsVisible: 10
                    },
                    moreParagraph: {
                        buttons: [
                            'alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'formatOL',
                            'formatUL', 'paragraphFormat', 'lineHeight', 'outdent', 'indent', 'quote'
                        ],
                        align: 'left',
                        buttonsVisible: 10
                    },
                    moreRich: {
                        buttons: [
                            'insertLink', 'insertImage',
                            'emoticons', 'specialCharacters', 'insertHR'
                        ],
                        align: 'left',
                        buttonsVisible: 10
                    },
                    moreMisc: {
                        buttons: [
                            'undo', 'redo', 'fullscreen', 'print', 'selectAll', 'html', 'help'
                        ],
                        align: 'right',
                        buttonsVisible: 10
                    }
                },

                quickInsertEnabled: true,

                // 🔹 Upload Gambar Langsung
                imageUpload: true,
                imageUploadURL: '/upload-image',
                imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],
                imageMaxSize: 5 * 1024 * 1024, // 5MB

                // 🔹 Kirim CSRF Token ke Laravel
                imageUploadParams: {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },

                // 🔹 Sedikit style biar tidak terlalu tinggi
                heightMin: 300,
                heightMax: 600
            });
        });
    </script>

    <script>
        document.querySelectorAll('.toggle-eye').forEach(eye => {
            eye.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const svg = this.querySelector('svg');

                if (input.type === "password") {
                    input.type = "text";
                    svg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 
                    0-8.268-2.943-9.542-7a10.05 10.05 0 011.718-3.04M6.97 
                    6.97A9.955 9.955 0 0112 5c4.478 0 8.268 2.943 9.542 
                    7a9.97 9.97 0 01-4.043 5.27M6.97 6.97l10.06 
                    10.06M6.97 6.97L5 5m12.03 12.03L19 19" />`;
                } else {
                    input.type = "password";
                    svg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 
                    0 8.268 2.943 9.542 7-1.274 4.057-5.064 
                    7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                }
            });
        });
    </script>
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

    <script src="{{ asset('assets/admin/libs/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/form-editor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/froala-editor@4.1.4/js/froala_editor.pkgd.min.js"></script>


</body>

</html>
