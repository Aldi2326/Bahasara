<header id="ts-header" class="fixed-top">
    <nav id="ts-primary-navigation" class="navbar navbar-expand-md navbar-light">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/img/Logo-Bahasara.png') }}" alt="">
            </a>

            <!-- Responsive Collapse Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarPrimary" aria-controls="navbarPrimary"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation -->
            <div class="collapse navbar-collapse" id="navbarPrimary">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ts-has-child">

                            <!--Main level link-->
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                                Peta
                                <span class="sr-only">(current)</span>
                            </a>

                            <!-- List (1st level) -->
                            <ul class="ts-child">

                                <!-- MAP (1st level)
                                =====================================================================================-->
                                <li class="nav-item ">

                                    <a href="/" class="nav-link">Bahasa</a>

                                </li>
                                <!--end MAP (1st level)-->

                                <!-- SLIDER (1st level)
                                =====================================================================================-->
                                <li class="nav-item ">

                                    <a href="/sastra" class="nav-link">Sastra</a>
                                </li>
                                <!--end SLIDER (1st level)-->

                                <!-- IMAGE (1st level)
                                =====================================================================================-->
                                <li class="nav-item ">

                                    <a href="/aksara" class="nav-link">Aksara</a>
                                </li>
                                <!--end SLIDER (1st level)-->

                            </ul>
                            <!--end List (1st level) -->

                        </li>

                    <li class="nav-item">
    <a class="nav-link {{ request()->is('tentang-kami') ? 'active' : '' }}" 
       href="{{ url('tentang-kami') }}">
       Tentang Kami
    </a>
</li>

                    <li class="nav-item">
    <a class="nav-link {{ request()->is('kontak') ? 'active' : '' }}" 
       href="{{ url('kontak') }}">
       Kontak
    </a>
</li>

                </ul>
            </div>
        </div>
    </nav>
</header>
