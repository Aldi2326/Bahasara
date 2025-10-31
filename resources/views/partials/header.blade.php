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
                    
                    <!-- 🔹 Menu Beranda -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                            href="{{ url('/') }}">
                            Beranda
                        </a>
                    </li>

                    <!-- 🔹 Menu Pemetaan -->
                    <li class="nav-item ts-has-child">
                        <a class="nav-link {{ request()->is('sastra') || request()->is('aksara') ? 'active' : '' }}" href="#">
                            Pemetaan
                        </a>

                        <!-- Submenu -->
                        <ul class="ts-child">
                            <li class="nav-item">
                                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Bahasa</a>
                            </li>
                            <li class="nav-item">
                                <a href="/sastra" class="nav-link {{ request()->is('sastra') ? 'active' : '' }}">Sastra</a>
                            </li>
                            <li class="nav-item">
                                <a href="/aksara" class="nav-link {{ request()->is('aksara') ? 'active' : '' }}">Aksara</a>
                            </li>
                        </ul>
                    </li>

                    <!-- 🔹 Menu Tentang Kami -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('tentang-kami') ? 'active' : '' }}"
                            href="{{ url('tentang-kami') }}">
                            Tentang Kami
                        </a>
                    </li>

                    <!-- 🔹 Menu Hubungi Kami -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('kontak') ? 'active' : '' }}"
                            href="{{ url('kontak') }}">
                            Hubungi Kami
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>
