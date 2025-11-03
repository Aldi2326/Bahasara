<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="ThemeStarz">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/bahasara-logo.png') }}">

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init({
                duration: 1000, // durasi animasi (ms)
                once: true // animasi hanya sekali saat muncul
            });
        });
    </script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Tambahkan di head (kalau belum ada) -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-multiselect@1.1.1/dist/css/bootstrap-multiselect.css">


    <link href="{{ asset('assets/admin/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css">

    <title>@yield('title', 'MyHouse')</title>
    <style>
        .prose ul,
        ol {
            all: revert;
        }

        .prose li {
            all: revert;
        }

        
        
    </style>
</head>

<body>

    <div class="ts-page-wrapper ts-homepage" id="page-top">

        {{-- Header --}}
        @include('partials.header')

        {{-- Content --}}
        <main>
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('partials.footer')

    </div>
    <!-- Tambahkan sebelum </body> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-multiselect@1.1.1/dist/js/bootstrap-multiselect.min.js"></script>
    <!-- JS -->
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/sly.min.js') }}"></script>
    <script src="{{ asset('assets/js/dragscroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/leaflet.js') }}"></script>
    <script src="{{ asset('assets/js/leaflet.markercluster.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/map-leaflet.js') }}"></script>

    <script src="{{ asset('assets/admin/libs/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/form-editor.js') }}"></script>

</body>

</html>