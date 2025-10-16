<aside id="app-menu"
            class="hs-overlay fixed inset-y-0 start-0 z-60 hidden w-sidenav min-w-sidenav bg-slate-800 overflow-y-auto -translate-x-full transform transition-all duration-200 hs-overlay-open:translate-x-0 lg:bottom-0 lg:end-auto lg:z-30 lg:block lg:translate-x-0 rtl:translate-x-full rtl:hs-overlay-open:translate-x-0 rtl:lg:translate-x-0 print:hidden [--body-scroll:true] [--overlay-backdrop:true] lg:[--overlay-backdrop:false]">

            <div class="flex flex-col h-full">
                <!-- Sidenav Logo -->
                <div class="sticky top-0 flex h-topbar items-center justify-center px-6">
                    <a href="/">
                        <img src="{{ asset('assets/img/logo-bahasara-light.png') }}" alt="logo" class="flex h-10">
                    </a>
                </div>

                <div class="p-4 h-[calc(100%-theme('spacing.topbar'))] flex-grow" data-simplebar>
                    <!-- Menu -->
                    <ul class="admin-menu hs-accordion-group flex w-full flex-col gap-1">
                        <li class="px-3 py-2 text-xs uppercase font-medium text-default-500">Menu</li>

                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-400 transition-all hover:bg-default-100/5"
                                href="/admin/dashboard">
                                <i class="i-lucide-calendar size-5"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-400 transition-all hover:bg-default-100/5"
                                href="/admin/wilayah">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8.593c0-1.527 0-2.29.393-2.735c.139-.159.308-.285.497-.372c1.416-.653 3.272 1.066 4.77 1.013q.297-.011.587-.082c2.184-.535 3.552-3.08 5.798-3.39c1.287-.18 2.7.598 3.904 1.014c.99.342 1.485.513 1.768.92S21 5.91 21 6.99v8.422c0 1.526 0 2.29-.393 2.735a1.5 1.5 0 0 1-.497.371c-1.416.653-3.272-1.065-4.77-1.012a3 3 0 0 0-.587.081c-2.184.535-3.552 3.08-5.798 3.391c-1.281.178-4.847-.75-5.672-1.935C3 18.636 3 18.096 3 17.014zm6-2.052v14.255m6-17.615v14.255"/></svg>
                                Wilayah
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-400 transition-all hover:bg-default-100/5"
                                href="/admin/peta/bahasa">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-a-icon lucide-book-a"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/><path d="m8 13 4-7 4 7"/><path d="M9.1 11h5.7"/></svg>
                                Bahasa
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-400 transition-all hover:bg-default-100/5"
                                href="/admin/peta/sastra">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-icon lucide-book-open"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
                                Sastra
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-400 transition-all hover:bg-default-100/5"
                                href="/admin/peta/aksara">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-languages-icon lucide-languages"><path d="m5 8 6 6"/><path d="m4 14 6-6 2-3"/><path d="M2 5h12"/><path d="M7 2h1"/><path d="m22 22-5-10-5 10"/><path d="M14 18h6"/></svg>
                                Aksara
                            </a>
                        </li>

                        <!-- <li class="menu-item hs-accordion">
                            <a href="javascript:void(0)"
                                class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-400 transition-all hover:bg-default-100/5 hs-accordion-active:bg-default-100/5 hs-accordion-active:text-default-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8.593c0-1.527 0-2.29.393-2.735c.139-.159.308-.285.497-.372c1.416-.653 3.272 1.066 4.77 1.013q.297-.011.587-.082c2.184-.535 3.552-3.08 5.798-3.39c1.287-.18 2.7.598 3.904 1.014c.99.342 1.485.513 1.768.92S21 5.91 21 6.99v8.422c0 1.526 0 2.29-.393 2.735a1.5 1.5 0 0 1-.497.371c-1.416.653-3.272-1.065-4.77-1.012a3 3 0 0 0-.587.081c-2.184.535-3.552 3.08-5.798 3.391c-1.281.178-4.847-.75-5.672-1.935C3 18.636 3 18.096 3 17.014zm6-2.052v14.255m6-17.615v14.255"/></svg>
                    
                                <span class="menu-text"> Peta </span>
                                <span class="menu-arrow"></span>
                            </a>

                            <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                                <ul class="mt-1 space-y-1">
                                    <li class="menu-item">
                                        <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-400 transition-all hover:bg-default-100/5"
                                            href="/admin/peta/bahasa">
                                            <i class="menu-dot"></i>
                                            Bahasa
                                        </a>
                                    </li>

                                    <li class="menu-item">
                                        <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-400 transition-all hover:bg-default-100/5"
                                            href="/admin/peta/sastra">
                                            <i class="menu-dot"></i>
                                            Sastra
                                        </a>
                                    </li>

                                    <li class="menu-item">
                                        <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-400 transition-all hover:bg-default-100/5"
                                            href="/admin/peta/aksara">
                                            <i class="menu-dot"></i>
                                            Aksara
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            
                        </li> -->
                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-400 transition-all hover:bg-default-100/5"
                                href="/admin/pesan">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 1024 1024"><path fill="currentColor" d="M128 224v512a64 64 0 0 0 64 64h640a64 64 0 0 0 64-64V224zm0-64h768a64 64 0 0 1 64 64v512a128 128 0 0 1-128 128H192A128 128 0 0 1 64 736V224a64 64 0 0 1 64-64"/><path fill="currentColor" d="M904 224L656.512 506.88a192 192 0 0 1-289.024 0L120 224zm-698.944 0l210.56 240.704a128 128 0 0 0 192.704 0L818.944 224z"/></svg>
                                Pesan 
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-400 transition-all hover:bg-default-100/5"
                                href="/admin/pesan">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Pengguna 
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </aside>