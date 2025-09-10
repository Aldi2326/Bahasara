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
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Peta</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('tentang-kami') }}">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('kontak') }}">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
