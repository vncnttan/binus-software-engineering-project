@extends('templates.template')

@section('title', 'Home')

@section('content')
    <div class="xl:px-80 pt-6 px-2 flex flex-col gap-10">
        <div class="flex flex-col">
            <x-promo-carousel/>
        </div>
{{--        <div>--}}
{{--            <x-flash-sale-product-section/>--}}
{{--        </div>--}}
        <div class="flex flex-col pb-16">
            <h1 class="font-bold text-xl"> Based on your activity </h1>
            <x-recommended-product request-count="12"/>
        </div>
    </div>
@endsection
