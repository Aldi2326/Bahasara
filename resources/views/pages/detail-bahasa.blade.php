@extends('layouts.app')

@section('title', 'Peta Bahasa & Sastra')

@section('content')
<div class="container py-5">
    <h2 class="mb-3">{{ $bahasa->nama_bahasa }}</h2>
    <p><b>Status:</b> {{ $bahasa->status }}</p>
    <p><b>Jumlah Penutur:</b> {{ number_format($bahasa->jumlah_penutur, 0, ',', '.') }}</p>
    <p><b>Deskripsi:</b> {{ $bahasa->deskripsi }}</p>
</div>
@endsection
