@extends('app.layouts.app')
@section('content')
<!-- Wishlist Section Start -->
<section class="wishlist-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-3 g-2">
            @if($products && count($products) > 0)
                @foreach ($products as $product)
                    @include('app.product-wishlist-item', ['product' => $product, 'classContainer' => 'col-xxl-2 col-lg-3 col-md-4 col-6 product-box-contain wishlistItem', 'classType'=>'black'])
                @endforeach
            @else
                <div class="no-order-message" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                    <h3 class="text-content fw-light">You don't have items in wishlist yet.</h3>
                    <button onclick="location.href = '{{route('shop')}}';" class="btn theme-bg-color text-white btn-sm fw-bold mt-3">Shop now
                        <i class="fa-solid fa-arrow-right icon"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Wishlist Section End -->
@endsection