@extends('layouts.admin.app')

@section('title', 'Balas Pesan')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            Balas Pesan Pengguna
        </h2>

        <!-- Informasi Pengirim -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
            <p class="text-gray-700"><strong>Nama:</strong> {{ $kontak->nama }}</p>
            <p class="text-gray-700"><strong>Email:</strong> {{ $kontak->email }}</p>
            <p class="text-gray-700"><strong>Subjek:</strong> {{ $kontak->subjek }}</p>
        </div>

        <!-- Pesan User -->
        <div class="mb-6">
            <p class="font-semibold text-gray-700 mb-2">Pesan Pengguna:</p>

            <div class="bg-blue-50 border border-blue-200 text-gray-800 p-4 rounded-lg shadow-sm">
                <p class="leading-relaxed whitespace-pre-line">
                    {{ $kontak->pesan }}
                </p>
            </div>
        </div>

        <!-- Form Balasan -->
        <form id="replyForm" action="{{ route('kontak.reply', $kontak->id) }}" method="POST" class="space-y-4">
            @csrf

            <label for="reply_message" class="font-semibold text-gray-700">Tulis Balasan:</label>

            <textarea id="froala-editor" id="reply_message" name="reply_message" class="prose"></textarea>

            <button type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition font-semibold">
                Kirim Balasan
            </button>
        </form>

    </div>

</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('replyForm').addEventListener('submit', function (event) {
        event.preventDefault();

        Swal.fire({
            title: 'Kirim Balasan?',
            text: "Pastikan isi balasan sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#4B5563',
            confirmButtonText: 'Ya, kirim!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    });
</script>
@endsection
