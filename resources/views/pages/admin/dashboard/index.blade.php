@extends('layouts.admin.app')
@section('title', 'Dashboard')
@section('content')
    <div class="flex items-center md:justify-between flex-wrap gap-2 mb-5">
        <h4 class="text-default-900 text-lg font-semibold">Dashboard</h4>
        <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
            <a href="#" class="text-sm font-medium text-default-700">Drezoc</a>
            <i class="i-tabler-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
            <a href="#" class="text-sm font-medium text-default-700">Menu</a>
            <i class="i-tabler-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
            <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Dashboard</a>
        </div>
    </div>

    <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
        <!-- Card Bahasa -->
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Jumlah Bahasa</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ $counts['bahasa'] ?? 0 }}</h4>
                    </div>
                    <div class="rounded flex justify-center items-center size-12 bg-primary/10 text-primary">
                        <i class="material-symbols-rounded text-2xl">language</i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Wilayah -->
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Jumlah Wilayah</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ $counts['wilayah'] ?? 0 }}</h4>
                    </div>
                    <div class="rounded flex justify-center items-center size-12 bg-success/10 text-success">
                        <i class="material-symbols-rounded text-2xl">map</i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Aksara -->
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Jumlah Aksara</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ $counts['aksara'] ?? 0 }}</h4>
                    </div>
                    <div class="rounded flex justify-center items-center size-12 bg-warning/10 text-warning">
                        <i class="material-symbols-rounded text-2xl">draw</i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Sastra -->
        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs tracking-wide font-semibold uppercase text-default-700 mb-3">Jumlah Sastra</p>
                        <h4 class="font-semibold text-2xl text-default-700">{{ $counts['sastra'] ?? 0 }}</h4>
                    </div>
                    <div class="rounded flex justify-center items-center size-12 bg-danger/10 text-danger">
                        <i class="material-symbols-rounded text-2xl">menu_book</i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
