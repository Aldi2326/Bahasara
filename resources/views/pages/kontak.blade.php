@extends('layouts.app')

@section('title', 'Peta Bahasa & Sastra')

@section('content')
<div>



    <main id="ts-main">

        <!--PAGE TITLE
                            =========================================================================================================-->
        <section class="mt-5" id="page-title" style="padding-top: 100px;">
            <div class="container">
                <div class="ts-title">
                    @if (session('success'))
                    <div id="toast-success" class="toast-custom">
                        <span>{{ session('success') }}</span>
                        <span class="toast-close" onclick="closeToast()">×</span>
                    </div>

                    <script>
                        // Hilang otomatis setelah 3 detik
                        setTimeout(() => {
                            closeToast();
                        }, 3000);

                        function closeToast() {
                            const toast = document.getElementById('toast-success');
                            if (toast) {
                                toast.style.opacity = '0'; // efek fade out
                                setTimeout(() => toast.remove(), 500); // hapus elemen setelah animasi
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
                            /* hijau sukses */
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
</div>
</section>

<!--MAP
                            =========================================================================================================-->
<section id="map-address">

    <div class="container mb-5">
        <div class="ts-contact-map ts-map ts-shadow__sm position-relative">

            <!--Address on map-->
            <!-- <address class="position-absolute ts-bottom__0 ts-left__0 text-white m-3 p-4 ts-z-index__2" data-bg-color="rgba(0,0,0,.8)">
                                        <strong>Balai Bahasa Provinsi Jambi</strong>
                                        <br>
                                        Jalan Arif Rahman Hakim No. 101, Telanaipura Jambi
                                        <br>
                                        Indonesia, 36124
                                    </address> -->

            <!--Map-->
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.2292738392957!2d103.57259137455826!3d-1.6171257360763238!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2588f5c0b419f9%3A0xe4a980faaa00231!2sBalai%20Bahasa%20Provinsi%20Jambi.!5e0!3m2!1sen!2sid!4v1750088258135!5m2!1sen!2sid"
                width="1110" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

</section>

<!--CONTACT INFO & FORM
                            =========================================================================================================-->


<!--CONTACT INFO & FORM
                =========================================================================================================-->
<section id="contact-form">
    <div class="container">
        <div class="row">

            <!--CONTACTS (LEFT SIDE)
                            =============================================================================================-->
            <div class="col-md-4">

                <!--Title-->
                <h3>Hubungi Kami</h3>

                <p>
                    Apakah Anda memiliki pertanyaan, saran, atau ingin berkontribusi dalam pelestarian bahasa
                    dan sastra daerah di Provinsi Jambi? Kami sangat terbuka untuk kolaborasi dan masukan dari
                    masyarakat. Silakan hubungi kami melalui formulir atau informasi kontak di bawah ini.
                </p>

                <!--Phone-->
                <figure class="ts-center__vertical">
                    <i class="fa fa-phone ts-opacity__50 mr-3 mb-0 h4 font-weight-bold"></i>
                    <dl class="mb-0">
                        <dt>Telepon</dt>
                        <dd class="ts-opacity__50"> (0741) 669466</dd>
                    </dl>
                </figure>

                <!--Email-->
                <figure class="ts-center__vertical">
                    <i class="fa fa-envelope ts-opacity__50 mr-3 mb-0 h4 font-weight-bold"></i>
                    <dl class="mb-0">
                        <dt>Email</dt>
                        <dd class="ts-opacity__50">
                            <a href="#">bahasajambi@kemdikbud.go.id</a>
                        </dd>
                    </dl>
                </figure>

                <!--Facebook-->
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
            <!--end col-md-4-->

            <!--FORM (RIGHT SIDE)
                            =============================================================================================-->
            <div class="col-md-8">

                <!--Title-->
                <h3>Formulir Umpan Balik</h3>

                <!--Form-->
                <form id="form-contact" action="{{ route('kontak.store') }}" method="post"
                    class="clearfix ts-form ts-form-email" data-php-path="assets/php/email.php">
                    @csrf
                    <!--Row-->
                    <div class="row">

                        <!--Name-->
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="form-contact-name">Nama *</label>
                                <input type="text" class="form-control" id="form-contact-name" name="nama"
                                    placeholder="Nama" required>
                            </div>
                        </div>

                        <!--Email-->
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="form-contact-email">Email *</label>
                                <input type="email" class="form-control" id="form-contact-email"
                                    name="email" placeholder="Email" required>
                            </div>
                        </div>

                    </div>
                    <!--end row -->

                    <!--Subject-->
                    <div class="form-group">
                        <label for="form-contact-email">Subjek *</label>
                        <input type="text" class="form-control" id="form-contact-subject" name="subjek"
                            placeholder="Subjek" required>
                    </div>

                    <!--Message-->
                    <div class="form-group">
                        <label for="form-contact-message">Pesan *</label>
                        <textarea class="form-control" id="form-contact-message" rows="5" name="pesan" placeholder="Pesan" required></textarea>
                    </div>

                    <!--Submit button-->
                    <div class="form-group clearfix">
                        <button type="submit"
                            id="form-contact-submit"
                            class="btn btn-lg mt-3 px-4 float-right"
                            style="color: #17678d; border: 2px solid #17678d; transition: all 0.3s; background-color: transparent; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); font-size: 14px;"
                            onmouseover="this.style.backgroundColor='#17678d'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='#17678d';">
                            Kirim Pesan
                        </button>

                    </div>

                    <div class="form-contact-status"></div>

                </form>
                <!--end form-contact -->
            </div>
            <!--end col-md-8-->

        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>

<ol>
    <li>asdasasd</li>
    <li>dsadas</li>
    <li>dasds</li>
</ol>
<p>wqdwqdqwd</p>
<ul>
    <li>dssadas</li>
    <li>dasdsa</li>
    <li>dasdsa</li>
</ul>
<p><strong><em><u>sadsaas</u></em></strong></p>
<p><strong><em><u>sadsaas</u></em></strong></p>

</main>
<!--end #ts-main-->

</div>
@endsection