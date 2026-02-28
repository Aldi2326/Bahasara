<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/bahasara-logo.png') }}">

    <!-- Icons css -->
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App css -->
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css">
</head>

<body class="min-h-screen flex items-center justify-center bg-default-100">

    <div class="card w-[420px] !max-w-none" style="width: 450px;">
        <div class="p-6">
            <h4 class="card-title mb-4 text-center">Login Admin</h4>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1"
                        class="text-default-800 text-sm font-medium inline-block mb-2">Username</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input"
                        id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username" required>
                </div>
                @if ($errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3" style="position: relative;">
                    <label for="exampleInputPassword1"
                        class="text-default-800 text-sm font-medium inline-block mb-2">Password</label>

                    <input type="password" name="password" id="exampleInputPassword1" class="form-input"
                        placeholder="Password" required style="padding-right: 40px;"> <!-- ruang untuk icon -->

                    <!-- Icon Mata -->
                    <span onclick="togglePassword()"
                        style="
            position: absolute;
            right: 10px;
            top: 48px; 
            transform: translateY(-50%);
            cursor: pointer;
        ">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" width="20" height="20" style="color: gray;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478
                0 8.268 2.943 9.542 7-1.274 4.057-5.064
                7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </span>
                </div>

                <button type="submit" class="btn bg-primary text-white w-full">Login</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById("exampleInputPassword1");
            const eyeIcon = document.getElementById("eyeIcon");

            if (input.type === "password") {
                input.type = "text";
                eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 
                0-8.268-2.943-9.542-7a10.05 10.05 0 011.718-3.04M6.97 
                6.97A9.955 9.955 0 0112 5c4.478 0 8.268 2.943 9.542 
                7a9.97 9.97 0 01-4.043 5.27M6.97 6.97l10.06 
                10.06M6.97 6.97L5 5m12.03 12.03L19 19" />`;
            } else {
                input.type = "password";
                eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 
                0 8.268 2.943 9.542 7-1.274 4.057-5.064 
                7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>

    <!-- Scripts -->
    <script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/preline/preline.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/iconify-icon/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
</body>

</html>
