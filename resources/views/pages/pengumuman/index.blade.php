@extends('layouts.app')

@section('title', 'Pengumuman')

@section('content')
<div class="container mt-5" style="padding-top: 80px; padding-bottom: 50px;">

    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Pengumuman</h2>
            <p class="text-muted">Informasi terbaru yang dapat Anda lihat.</p>
        </div>
    </div>

    <div class="row g-4">
        @foreach ($pengumuman as $item)
            <a href="{{ route('pengumuman-user.show', $item->id) }}" class="col-md-6 col-lg-4 mt-4">
                <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">

                    <img src="{{ asset('storage/' . $item->dokumentasi) }}" class="card-img-top"
                        style="height: 200px; object-fit: cover;">

                    <div class="card-body">
                        <h5 class="card-title fw-semibold">{{ $item->judul }}</h5>
                        <p class="card-text text-muted">{{ Str::limit(strip_tags($item->isi), 80) }}</p>
                    </div>

                    <div class="card-footer bg-white">
                        <small class="text-muted">
                            <i class="bi bi-calendar"></i> {{ $item->tanggal }}
                        </small>
                    </div>

                </div>
            </a>
        @endforeach
    </div>
    {{-- Tombol Tampilkan Lebih Banyak --}}
    <div class="text-center mt-4">
        <button id="loadMoreBtn" class="px-4 py-2"
            style="background:#1b81ae; color:white; border-radius:8px; border:none;">
            Tampilkan Lebih Banyak
        </button>
    </div>
</div>
@endsection
