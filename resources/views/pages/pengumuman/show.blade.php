@extends('layouts.app')

@section('title', $pengumuman->judul)

@section('content')
<div class="container" style="padding-top: 160px; padding-bottom: 60px;">

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">

                {{-- Dokumentasi --}}
                <img src="{{ asset('storage/'.$pengumuman->dokumentasi) }}"
                     class="card-img-top"
                     style="height: 480px; object-fit: cover;">

                <div class="card-body p-4">

                    {{-- Judul --}}
                    <h2 class="fw-bold mb-3">{{ $pengumuman->judul }}</h2>

                    {{-- Tanggal --}}
                    <div class="mb-4 text-muted">
                        <i class="bi bi-calendar"></i> {{ $pengumuman->tanggal }}
                    </div>

                    {{-- Isi --}}
                    <div class="text-dark" style="line-height: 1.7;">
                        {!! $pengumuman->isi !!}
                    </div>

                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('pengumuman-user.index') }}" 
                   class="btn px-4"
                   style="background-color: #1b81ae; color: white; border-radius: 8px;">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
