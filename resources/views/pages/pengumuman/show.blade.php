@extends('layouts.app')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="container" style="padding-top: 160px; padding-bottom: 60px;">

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">

                {{-- Gambar Pengumuman --}}
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}"
                     class="card-img-top"
                     style="height: 480px; object-fit: cover;">

                <div class="card-body p-4">

                    {{-- Judul --}}
                    <h2 class="fw-bold mb-3">
                        Judul Pengumuman
                    </h2>

                    {{-- Tanggal --}}
                    <div class="mb-4 text-muted">
                        <i class="bi bi-calendar"></i> 10 Januari 2025
                    </div>

                    {{-- Isi Pengumuman --}}
                    <p class="text-dark" style="line-height: 1.7;">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Morbi vitae diam non elit tincidunt aliquet.
                        Suspendisse potenti. Etiam venenatis aliquam justo sit amet facilisis.
                    </p>

                    <p class="text-dark" style="line-height: 1.7;">
                        Vestibulum vulputate bibendum nulla, sed commodo arcu dapibus id.
                        Sed maximus ligula et nunc posuere, et ornare nulla scelerisque.
                    </p>

                </div>
            </div>

            {{-- Tombol Kembali di bawah card --}}
            <div class="text-center">
                <a href="{{ route('pengumuman.index') }}" 
                   class="btn px-4"
                   style="background-color: #1b81ae; color: white; border-radius: 8px;">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
