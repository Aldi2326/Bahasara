@extends('layouts.app')

@section('title', 'Peta Bahasa & Sastra')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@section('content')
    <div>
        <main id="ts-main">

            <!--PAGE TITLE-->
            <section class="mt-5" id="page-title" style="padding-top: 100px;">
                <div class="container">
                    <div class="ts-title">
                        @if (session('success'))
                            <div id="toast-success" class="toast-custom">
                                <span>{{ session('success') }}</span>
                                <span class="toast-close" onclick="closeToast()">×</span>
                            </div>

                            <script>
                                setTimeout(() => {
                                    closeToast();
                                }, 3000);

                                function closeToast() {
                                    const toast = document.getElementById('toast-success');
                                    if (toast) {
                                        toast.style.opacity = '0';
                                        setTimeout(() => toast.remove(), 500);
                                    }
                                }
                            </script>

                            <style>
                                .toast-custom {
                                    position: fixed;
                                    top: 20px;
                                    right: 20px;
                                    min-width: 250px;
                                    max-width: 350px;
                                    background-color: #28a745;
                                    color: white;
                                    padding: 12px 16px;
                                    border-radius: 8px;
                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                    gap: 10px;
                                    z-index: 9999;
                                    transition: opacity 0.5s ease;
                                }

                                .toast-close {
                                    cursor: pointer;
                                    font-size: 18px;
                                    font-weight: bold;
                                }

                                .toast-close:hover {
                                    color: #ddd;
                                }
                            </style>
                        @endif
                    </div>
                </div>
            </section>

            <!--MAP-->
            <section id="map-address">
                <div class="container mb-5">
                    <div class="ts-contact-map ts-map ts-shadow__sm position-relative">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.2292738392957!2d103.57259137455826!3d-1.6171257360763238!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2588f5c0b419f9%3A0xe4a980faaa00231!2sBalai%20Bahasa%20Provinsi%20Jambi.!5e0!3m2!1sen!2sid!4v1750088258135!5m2!1sen!2sid"
                            width="1110" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </section>

            <!--CONTACT INFO & FORM-->
            <section id="contact-form">
                <div class="container">
                    <div class="row">
                        <!-- Left Side -->
                        <div class="col-md-4">
                            <h3>Hubungi Kami</h3>
                            <p>
                                Apakah Anda memiliki pertanyaan, saran, atau ingin berkontribusi dalam pelestarian bahasa
                                dan sastra daerah di Provinsi Jambi? Kami sangat terbuka untuk kolaborasi dan masukan dari
                                masyarakat. Silakan hubungi kami melalui formulir atau informasi kontak di bawah ini.
                            </p>

                            <figure class="ts-center__vertical">
                                <i class="fa fa-phone ts-opacity__50 mr-3 mb-0 h4 font-weight-bold"></i>
                                <dl class="mb-0">
                                    <dt>Telepon</dt>
                                    <dd class="ts-opacity__50">(0741) 669466</dd>
                                </dl>
                            </figure>

                            <figure class="ts-center__vertical">
                                <i class="fa fa-envelope ts-opacity__50 mr-3 mb-0 h4 font-weight-bold"></i>
                                <dl class="mb-0">
                                    <dt>Email</dt>
                                    <dd class="ts-opacity__50">
                                        <a href="#">bahasajambi@kemdikbud.go.id</a>
                                    </dd>
                                </dl>
                            </figure>

                            <figure class="ts-center__vertical">
                                <i class="fab fa-facebook ts-opacity__50 mr-3 mb-0 h4 font-weight-bold"></i>
                                <dl class="mb-0">
                                    <dt>Facebook</dt>
                                    <dd class="ts-opacity__50">
                                        <a href="#">Balai Bahasa Provinsi Jambi</a>
                                    </dd>
                                </dl>
                            </figure>
                        </div>

                        <!-- Right Side (Form) -->
                        <div class="col-md-8">
                            <h3>Formulir Umpan Balik</h3>

                            <form id="form-contact" action="{{ route('kontak.store') }}" method="post"
                                class="clearfix ts-form ts-form-email" data-php-path="assets/php/email.php">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="form-contact-name">Nama *</label>
                                            <input type="text" class="form-control" id="form-contact-name" name="nama"
                                                value="{{ old('nama') }}" placeholder="Nama" required>
                                        </div>
                                        @error('nama')
                                            <small class="text-danger d-block mt-2">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="form-contact-email">Email *</label>
                                            <input type="email" class="form-control" id="form-contact-email"
                                                name="email" value="{{ old('email') }}" placeholder="Email" required>
                                        </div>
                                        @error('email')
                                            <small class="text-danger d-block mt-2">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="form-contact-email">Subjek *</label>
                                    <input type="text" class="form-control" id="form-contact-subject" name="subjek"
                                        value="{{ old('subjek') }}" placeholder="Subjek" required>
                                    @error('subjek')
                                        <small class="text-danger d-block mt-2">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="form-contact-message">Pesan *</label>
                                    <textarea class="form-control" id="form-contact-message" rows="5" name="pesan" placeholder="Pesan" required>{{ old('pesan') }}</textarea>
                                </div>
                                @error('pesan')
                                    <small class="text-danger d-block mt-2">
                                        {{ $message }}
                                    </small>
                                @enderror

                                <div class="form-group mt-4">
                                    <label>Pertanyaan Keamanan *</label>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="mr-2">{!! captcha_img('math') !!}</span>
                                    </div>
                                    
                                    <input type="text" class="form-control" name="captcha" placeholder="Masukkan hasil perhitungan" required>
                                    
                                    @error('captcha')
                                        <small class="text-danger d-block mt-2">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>


                                <div class="form-group clearfix">
                                    <button type="submit" id="form-contact-submit" class="btn btn-lg mt-3 px-4 float-right"
                                        style="color: #1b81ae; border: 2px solid #1b81ae; transition: all 0.3s; background-color: transparent; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); font-size: 14px;"
                                        onmouseover="this.style.backgroundColor='#1b81ae'; this.style.color='white';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#1b81ae';">
                                        Kirim Pesan
                                    </button>
                                </div>

                                <div class="form-contact-status"></div>
                            </form>

                            @if (session('focus_captcha'))
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const captcha = document.getElementById('captcha-wrapper');
                                        if (captcha) {
                                            captcha.scrollIntoView({
                                                behavior: 'smooth',
                                                block: 'center'
                                            });
                                        }
                                    });
                                </script>
                            @endif

                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <style>
        /* Tambahkan border radius ke semua input dan textarea */
        #form-contact .form-control {
            border-radius: 12px !important;
        }

        /* Tambahkan efek hover ringan */
        #form-contact .form-control:focus {
            border-color: #1b81ae;
            box-shadow: 0 0 5px rgba(27, 129, 174, 0.3);
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. MATIKAN fitur browser yang mengingat posisi scroll terakhir.
            // Ini PENTING agar browser tidak memaksa layar kembali ke tombol submit.
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }

            // 2. Gunakan setTimeout agar script jalan SETELAH browser selesai me-render halaman
            setTimeout(function() {
                // Cari elemen error (prioritaskan pesan text merah dulu karena pasti terlihat)
                let errorElement = document.querySelector('.text-danger');
                
                // Jika tidak ada text merah, cari input yang border merah
                if (!errorElement) {
                    errorElement = document.querySelector('.border-red-500');
                }

                if (errorElement) {
                    // Debugging: Cek di console apakah elemen ketemu
                    console.log("Scroll ke:", errorElement);

                    // 3. Scroll dengan opsi 'center' agar elemen pas di tengah mata
                    errorElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center', 
                        inline: 'nearest'
                    });

                    // 4. Fokus kursor (hanya jika elemennya input biasa)
                    if (['INPUT', 'SELECT', 'TEXTAREA'].includes(errorElement.tagName)) {
                        // preventScroll: true agar tidak bentrok dengan scrollIntoView di atas
                        errorElement.focus({ preventScroll: true }); 
                    }
                } else {
                    // Jika tidak ada error, kembalikan scroll ke paling atas
                    window.scrollTo(0, 0);
                }
            }, 300); // Delay 300ms (0.3 detik) memberi waktu browser "bernapas" dulu
            
        });
    </script>
@endsection
