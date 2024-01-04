@extends('app.layouts.app')
@section('content')
@push('css')
<link rel="stylesheet" href="{!! asset('css/cart-empty.css') !!}">
@endpush
<main class="m-t-40">
    <div class="menu-container breadcrumbs">
        <span><a href="{{route('homepage')}}">{{trans('app.home')}}</a></span>
        <span></span>
        <span>{{trans('app.cart')}}</span>
    </div>

    <div class="wrapper">
        <div class="basket m-b-80 p-t-24 text-center">
            <p>{{trans('app.cart')}}</p>
        </div>

        <div class="empty text-center m-b-40">{{trans('app.empty_cart')}}</div>

        <div class="shopping_button_wrapper d-flex justify-content-center">
            <button class="shopping_button d-flex justify-content-center align-items-center border-0">
                <a href="{{route('homepage')}}" style="text-decoration: none; color:#fff;">    
                    <span>{{trans('app.start_shoping')}}</span>
                    <img src="{{ asset('assets/img/icons/chevron_left.svg') }}" alt="">
                </a>
            </button>
        </div>
    </div>

    @include('app.blocks.simple_item_list', ['items' => $listItem,'blockTitle' => trans('app.sub_title_interest')])
</main>
@endsection