@extends('layouts.app')

@section('title', 'Peta Bahasa & Sastra')

@section('content')
<!--PAGE TITLE ******************************************************************************************-->
        <section id="page-title">
            <div class="container">
                <div class="ts-title">
                    <h1>Tentang Kami</h1>
                </div>
                <!--end ts-title-->
            </div>
            <!--end container-->
        </section>

        <!--DESCRIPTION *****************************************************************************************-->
        <section id="about-us-description">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <p class="h3" color = "#000037" >
                            BAHASARA
                        </p>
                        <p class="mb-5">
                            Bahasara adalah platform sistem informasi geografis berbasis web yang menampilkan data persebaran bahasa dan sastra daerah di Provinsi Jambi. Website ini dikembangkan sebagai bentuk pelestarian warisan budaya takbenda, khususnya dalam bidang kebahasaan dan kesastraan yang hidup dan berkembang di tengah masyarakat Jambi.
                        </p>
                        <a href="contact.html" class="btn btn-primary">Kontak Kami</a>
                    </div>
                    <!--end col-md-8-->
                    <div class="col-md-4"></div>
                    <!--end col-md-4-->
                </div>
                <!--end row-->
                <hr class="my-5">
            </div>
            <!--end container-->
        </section>

        <!--TEAM
            =========================================================================================================-->
        <section id="about-us-team">
            <div class="container pb-5">
                <div class="row">

                    <!--Person-->
                    <div class="col-md-3">
                        <div class="card ts-person ts-card">

                            <!--Ribbon-->
                            <div class="ts-ribbon">
                                <i class="fa fa-thumbs-up"></i>
                            </div>

                            <!--Image-->
                            <a href="#" class="card-img" data-bg-image="assets/img/img-person-01.jpg">
                                <div class="ts-item__info-badge">
                                    <span>23 Properties</span>
                                </div>
                            </a>

                            <!--Body-->
                            <div class="card-body">

                                <figure class="ts-item__info">
                                    <h4>Jane Harwood</h4>
                                    <aside>
                                        <i class="fa fa-map-marker mr-2"></i>
                                        London
                                    </aside>
                                </figure>

                                <dl>
                                    <dt>Phone</dt>
                                    <dd>+1 602-862-1673</dd>
                                    <dt>Email</dt>
                                    <dd><a href="#">jane.harwood@example.com</a></dd>
                                </dl>

                            </div>

                            <!--Footer-->
                            <a href="agent-detail-01.html" class="card-footer">
                                <span class="ts-btn-arrow">Detail</span>
                            </a>

                        </div>
                    </div>
                    <!--end col-md-3-->

                    <!--Person-->
                    <div class="col-md-3">
                        <div class="card ts-person ts-card">

                            <!--Ribbon-->
                            <div class="ts-ribbon">
                                <i class="fa fa-thumbs-up"></i>
                            </div>

                            <!--Image-->
                            <a href="#" class="card-img" data-bg-image="assets/img/img-person-02.jpg">
                                <div class="ts-item__info-badge">
                                    <span>41 Properties</span>
                                </div>
                            </a>

                            <!--Body-->
                            <div class="card-body">

                                <figure class="ts-item__info">
                                    <h4>Jackie Kinsey</h4>
                                    <aside>
                                        <i class="fa fa-map-marker mr-2"></i>
                                        New York
                                    </aside>
                                </figure>

                                <dl>
                                    <dt>Phone</dt>
                                    <dd>+1 602-862-1673</dd>
                                    <dt>Email</dt>
                                    <dd><a href="#">jane.harwood@example.com</a></dd>
                                </dl>

                            </div>

                            <!--Footer-->
                            <a href="agent-detail-01.html" class="card-footer">
                                <span class="ts-btn-arrow">Detail</span>
                            </a>

                        </div>
                    </div>
                    <!--end col-md-3-->

                    <!--Person-->
                    <div class="col-md-3">
                        <div class="card ts-person ts-card">

                            <!--Image-->
                            <a href="#" class="card-img" data-bg-image="assets/img/img-person-03.jpg">
                                <div class="ts-item__info-badge">
                                    <span>16 Properties</span>
                                </div>
                            </a>

                            <!--Body-->
                            <div class="card-body">

                                <figure class="ts-item__info">
                                    <h4>Adam Price</h4>
                                    <aside>
                                        <i class="fa fa-map-marker mr-2"></i>
                                        Paris
                                    </aside>
                                </figure>

                                <dl>
                                    <dt>Phone</dt>
                                    <dd>+1 602-862-1673</dd>
                                    <dt>Email</dt>
                                    <dd><a href="#">jane.harwood@example.com</a></dd>
                                </dl>

                            </div>

                            <!--Footer-->
                            <a href="agent-detail-01.html" class="card-footer">
                                <span class="ts-btn-arrow">Detail</span>
                            </a>

                        </div>
                    </div>
                    <!--end col-md-3-->

                    <!--Person-->
                    <div class="col-md-3">
                        <div class="card ts-person ts-card">

                            <!--Image-->
                            <a href="#" class="card-img" data-bg-image="assets/img/img-person-04.jpg">
                                <div class="ts-item__info-badge">
                                    <span>28 Properties</span>
                                </div>
                            </a>

                            <!--Body-->
                            <div class="card-body">

                                <figure class="ts-item__info">
                                    <h4>Edward Palmer</h4>
                                    <aside>
                                        <i class="fa fa-map-marker mr-2"></i>
                                        Berlin
                                    </aside>
                                </figure>

                                <dl>
                                    <dt>Phone</dt>
                                    <dd>+1 602-862-1673</dd>
                                    <dt>Email</dt>
                                    <dd><a href="#">jane.harwood@example.com</a></dd>
                                </dl>

                            </div>

                            <!--Footer-->
                            <a href="agent-detail-01.html" class="card-footer">
                                <span class="ts-btn-arrow">Detail</span>
                            </a>

                        </div>
                    </div>
                    <!--end col-md-3-->

                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>

        <!--TESTIMONIALS ****************************************************************************************-->
        <section id="about-us-testimonials-carousel">
            <div class="bg-white text-center py-5">
                <div class="container">
                    <div class="offset-lg-2 col-lg-8">
                        <div class="owl-carousel" data-owl-items="1" data-owl-dots="1">

                            <div class="ts-slide">
                                <div class="ts-circle__sm" data-bg-image="assets/img/img-person-01.jpg"></div>
                                <h5 class="my-3">Jane Doe</h5>
                                <p class="h5 font-weight-normal ts-text-color-light">
                                    Duis ac dolor et enim volutpat semper. Morbi placerat tempor ornare. Quisque
                                    bibendum
                                    ultrices diam, ac fermentum massa egestas quis.
                                </p>
                            </div>
                            <!--end ts-slide-->

                            <div class="ts-slide">
                                <div class="ts-circle__sm" data-bg-image="assets/img/img-person-02.jpg"></div>
                                <h5 class="my-3">Catherine Pride</h5>
                                <p class="h5 font-weight-normal ts-text-color-light">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec placerat tempor
                                    sapien.
                                    In lobortis posuere tincidunt. Curabitur malesuada tempus ligula nec
                                </p>
                            </div>
                            <!--end ts-slide-->

                        </div>
                        <!--end owl-carousel-->
                    </div>
                    <!--end offset-lg-2-->
                </div>
                <!--end container-->
            </div>
            <!--end ts-block-->
        </section>

        <!--NUMBERS *********************************************************************************************-->
        <section id="about-us-numbers">
            <div id="numbers" class="py-5 text-white text-center ts-separate-bg-element" data-bg-color="#000037" data-bg-image="assets/img/bg-apartment-table.jpg" data-bg-image-opacity=".3">
                <div class="container py-5">
                    <div class="ts-promo-numbers">
                        <div class="row">

                            <div class="col-sm-3">
                                <div class="ts-promo-number">
                                    <h2>640</h2>
                                    <h4 class="mb-0 ts-opacity__50">Properties</h4>
                                </div>
                                <!--end ts-promo-number-->
                            </div>
                            <!--end col-sm-3-->

                            <div class="col-sm-3">
                                <div class="ts-promo-number">
                                    <h2>350</h2>
                                    <h4 class="mb-0 ts-opacity__50">Local Agents</h4>
                                </div>
                                <!--end ts-promo-number-->
                            </div>
                            <!--end col-sm-3-->

                            <div class="col-sm-3">
                                <div class="ts-promo-number">
                                    <h2>23</h2>
                                    <h4 class="mb-0 ts-opacity__50">Years Experience</h4>
                                </div>
                                <!--end ts-promo-number-->
                            </div>
                            <!--end col-sm-3-->

                            <div class="col-sm-3">
                                <div class="ts-promo-number">
                                    <h2>67</h2>
                                    <h4 class="mb-0 ts-opacity__50">Agencies</h4>
                                </div>
                                <!--end ts-promo-number-->
                            </div>
                            <!--end col-sm-3-->

                        </div>
                        <!--end row-->
                    </div>
                    <!--end ts-promo-numbers-->
                </div>
                <!--end container-->
            </div>
            <!--end #numbers-->
        </section>

        <!--PARTNERS ********************************************************************************************-->
        <section id="partners">
            <div class="ts-block py-4">
                <div class="container">
                    <!--block of logos-->
                    <div class="d-block d-md-flex justify-content-between align-items-center text-center ts-partners py-3">
                        <a href="#">
                            <img src="assets/img/logo-01.png" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/img/logo-02.png" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/img/logo-03.png" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/img/logo-04.png" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/img/logo-05.png" alt="">
                        </a>
                    </div>
                    <!--end logos-->
                </div>
                <!--end container-->
            </div>
        </section>

    </main>
@endsection


