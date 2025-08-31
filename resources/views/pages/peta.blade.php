@extends('layouts.app')

@section('title', 'Peta Bahasa & Sastra')

@section('content')
<section id="ts-hero" class="mb-0">
    <div class="ts-full-screen ts-has-horizontal-results w-1001 d-flex1 flex-column1">
        <div class="ts-map ts-shadow__sm">

            {{-- Search Form dipanggil dari partial --}}
            @include('partials.search-form')

            <!-- Map -->
            <div id="ts-map-hero" class="h-100 ts-z-index__1"
                 data-ts-map-leaflet-provider="https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png"
                 data-ts-map-leaflet-attribution="&copy; <a href='http://www.openstreetmap.org/copyright'>OpenStreetMap</a> &copy; <a href='http://cartodb.com/attributions'>CartoDB</a>"
                 data-ts-map-zoom-position="bottomright"
                 data-ts-map-scroll-wheel="1"
                 data-ts-map-zoom="13"
                 data-ts-map-center-latitude="40.702411"
                 data-ts-map-center-longitude="-73.556842"
                 data-ts-locale="en-US"
                 data-ts-currency="USD"
                 data-ts-unit="m<sup>2</sup>"
                 data-ts-display-additional-info="area_Area;bedrooms_Bedrooms;bathrooms_Bathrooms">
            </div>
        </div>
    </div>
</section>
@endsection
