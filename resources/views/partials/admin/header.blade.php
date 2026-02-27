<header class="app-header sticky top-0 z-50 min-h-topbar flex items-center bg-white">
    <div class="px-6 w-full flex items-center justify-between gap-4">
        <div class="flex items-center gap-5">
            <button
                class="flex items-center text-default-500 rounded-full cursor-pointer p-2 bg-white border border-default-200 hover:bg-primary/15 hover:text-primary hover:border-primary/5 transition-all"
                data-hs-overlay="#app-menu" aria-label="Toggle navigation">
                <i class="i-lucide-align-left text-2xl"></i>
            </button>

            
            <a href="index.html" class="md:hidden flex">
                <img src="{{ asset('assets/img/logo-sibaraja-light.png') }}" class="h-5" alt="Small logo">
            </a>

        </div>

        <div class="flex items-center gap-5">
            <div class="md:flex hidden">
                <button data-toggle="fullscreen" type="button"
                    class="p-2 rounded-full bg-white border border-default-200 hover:bg-primary/15 hover:text-primary transition-all">
                    <span class="sr-only">Fullscreen Mode</span>
                    <span class="flex items-center justify-center size-6">
                        <i class="i-lucide-maximize text-2xl flex group-[-fullscreen]:hidden"></i>
                        <i class="i-lucide-minimize text-2xl hidden group-[-fullscreen]:flex"></i>
                    </span>
                </button>
            </div>

            <div class="relative">
                <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                    <button type="button" class="hs-dropdown-toggle">
                        <img src="{{ asset('assets/img/user-png-33842.png') }}" alt="user-image"
                            class="rounded-full h-10">
                    </button>
                    <div
                        class="hs-dropdown-menu duration mt-2 min-w-48 rounded-lg border border-default-200 bg-white p-2 opacity-0 shadow-md transition-[opacity,margin] hs-dropdown-open:opacity-100 hidden">

                        <form method="POST" action="{{ route('logout') }}"
                            onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
                            @csrf
                            <button type="submit"
                                class="w-full text-left py-2 px-3 rounded-md text-sm text-default-800 hover:bg-default-100">
                                Log Out
                            </button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</header>