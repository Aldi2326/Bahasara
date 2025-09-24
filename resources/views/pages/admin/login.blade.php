<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/bahasara-logo.png') }}">

    <!-- Icons css -->
    <link href="{{ asset('assets/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <!-- App css -->
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css">
</head>

<body class="min-h-screen flex items-center justify-center bg-default-100">

    <div class="card w-[420px] !max-w-none" style="width: 450px;">
        <div class="p-6">
            <h4 class="card-title mb-4 text-center">Login Admin</h4>

            <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="text-default-800 text-sm font-medium inline-block mb-2">Username</label>
                    <input type="text" class="form-input" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username">
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="text-default-800 text-sm font-medium inline-block mb-2">Password</label>
                    <input type="password" class="form-input" id="exampleInputPassword1" placeholder="Password">
                </div>

                <button type="submit" class="btn bg-primary text-white w-full">Login</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/preline/preline.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/iconify-icon/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
</body>

</html>
