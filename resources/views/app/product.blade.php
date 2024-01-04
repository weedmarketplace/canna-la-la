@extends('app.layouts.app')
@section('content')
<!-- Product Left Sidebar Start -->
<section class="product-section section-b-space" id="productPage">
    <input type="hidden" id="mainProductId" value="{{$product->id}}">
    <input type="hidden" id="selectedPriceId" value="{{$product->price_id}}">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                <div class="row g-4">
                    <div class="col-xl-6 wow fadeInUp">
                        <div class="product-left-box">
                            @if($product->images && count($product->images) > 0)
                            <div class="row g-2">
                                <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                    <div class="product-main-2 no-arrow">
                                        @foreach($product->images as $key => $img)
                                        <div>
                                            <div class="slider-image">
                                                <img src="{{$img['big']}}" id="img-1"
                                                    data-zoom-image="{{$img['small']}}"
                                                    class="img-fluid image_zoom_cls-{{$key}} blur-up lazyload" alt="">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                                    <div class="left-slider-image-2 left-slider no-arrow slick-top">
                                        @foreach($product->images as $key => $img)
                                        <div>
                                            <div class="sidebar-image">
                                                <img src="{{$img['small']}}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="right-box-contain">
                            @if($product->discount > 0)
                            <h6 class="offer-top">{{$product->discount}}% Off</h6>
                            @endif
                            <h2 class="name">{{$product->title}}</h2>
                            <div class="price-rating">
                                <h3 class="theme-color price">@currency($product->effective_price) @if($product->discount > 0)<del class="text-content">@currency($product->price)</del>
                                @endif</h3>
                            </div>

                            <div class="procuct-contain">
                                <p>{{$product->description}}</p>
                            </div>

                            <div class="product-packege">
                                <div class="product-title">
                                    <h4>Weight</h4>
                                </div>
                                <ul class="select-packege">
                                    @if($product->pricing_type == 'by_weight')
                                        @foreach($product->prices_by_weight as $price)
                                            <li>
                                                <a href="javascript:void(0)" 
                                                data-price-id="{{$price->price_id}}" 
                                                data-effective-price="{{$price->effective_price}}"
                                                data-original-price="{{$price->price}}" 
                                                data-discount="{{$product->discount}}"
                                                class="{{$price->price_id == $product->price_id ? 'active' : ''}}">{{$price->unit}}</a>
                                            </li>
                                        @endforeach
                                    @else
                                        <li>
                                            <a href="javascript:void(0)" 
                                            data-price-id="{{$product->price_id}}" 
                                            data-effective-price="{{$product->effective_price}}"
                                            data-original-price="{{$product->price}}" 
                                            data-discount="{{$product->discount}}"
                                            class="active">1 Unit</a>
                                        </li>
                                    @endif
                                </ul>
                                <?php /*
                                <ul class="select-packege">
                                @if($product->pricing_type == 'by_weight')
                                    @foreach($product->prices_by_weight as $price)
                                    <li>
                                        <a href="javascript:void(0)" data-price-id="{{$price->price_id}}" class="{{$price->price_id == $product->price_id ? 'active' : ''}}">{{$price->unit}}</a>
                                    </li>
                                    @endforeach
                                @else
                                    <li>
                                        <a href="javascript:void(0)" data-price-id="{{$product->price_id}}" class="active">1 Unit</a>
                                    </li>
                                @endif
                                </ul>
                                */?>
                            </div>

                            <div class="note-box product-packege">
                                <div class="cart_qty qty-box product-qty">
                                    <div class="input-group">
                                        <button type="button" class="qty-left-minus product-page-btn" data-type="minus"
                                            data-field="">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </button>
                                        <input id="mainQty" min="1" class="form-control input-number qty-input" type="number"
                                        name="quantity" value="1">
                                        <button type="button" class="qty-right-plus product-page-btn" data-type="plus" data-field="">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                        
                                    </div>
                                </div>

                                <button class="btn btn-md bg-dark cart-button text-white w-100 add-cart-button">Add To Cart</button>
                            </div>

                            <div class="buy-box">
                                <a class="notifi-wishlist from-product-view" href="javascript:void(0)" data-price-id="{{$product->price_id}}" data-product-id="{{$product->id}}">
                                    <i data-feather="heart"></i>
                                    <span>Add To Wishlist</span>
                                </a>
                            </div>

                            <div class="pickup-box">
                                <div class="product-info">
                                    <ul class="product-info-list product-info-list-2">
                                        <li>Category : <span class="product-attr-filed">{{$product->category_title}}</span></li>
                                        @if(isset($product->strain))
                                            <li>Strain : <span class="product-attr-filed">{{$product->strain}}</span></li>
                                        @endif
                                        @if(isset($product->genetic))
                                            <li>Genetic : <span class="product-attr-filed">{{$product->genetic}}</span></li>
                                        @endif
                                        @if($product->cannabinoid)
                                            <li>Cannabinoid :
                                                <span class="product-attr-filed">
                                                    {{$product->cannabinoid}}
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="product-section-box">
                            <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                        data-bs-target="#description" type="button" role="tab"
                                        aria-controls="description" aria-selected="true">Description</button>
                                </li>

                            </ul>

                            <div class="tab-content custom-tab" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel"
                                    aria-labelledby="description-tab">
                                    <div class="product-description">
                                        <div class="nav-desh">
                                            {!!$product->body!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                <div class="right-sidebar-box">
                    @if(isset($adminConfig['phone']))
                    <div class="vendor-box">
                        <div class="vendor-list">
                            <ul>
                                <li>
                                    <div class="address-contact">
                                        <i data-feather="headphones"></i>
                                        <h5>Contact: <span class="text-content">{{$adminConfig['phone']}}</span></h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    <!-- Trending Product -->
                    @if($trandingProducts && count($trandingProducts) > 0)
                    <div class="pt-25">
                        @include('app.blocks.trending_items')
                    </div>
                    @endif
                    <!-- Banner Section -->
                    <!-- <div class="ratio_156 pt-25">
                        <div class="home-contain">
                            <img src="../assets/images/vegetable/banner/8.jpg" class="bg-img blur-up lazyload"
                                alt="">
                            <div class="home-detail p-top-left home-p-medium">
                                <div>
                                    <h6 class="text-yellow home-banner">Seafood</h6>
                                    <h3 class="text-uppercase fw-normal"><span
                                            class="theme-color fw-bold">Freshes</span> Products</h3>
                                    <h3 class="fw-light">every hour</h3>
                                    <button onclick="location.href = 'shop-left-sidebar.html';"
                                        class="btn btn-animation btn-md fw-bold mend-auto">Shop Now <i
                                            class="fa-solid fa-arrow-right icon"></i></button>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Left Sidebar End -->

@if($relatedProducts && count($relatedProducts) > 0)
<!-- Releted Product Section Start -->
<section class="product-list-section section-b-space">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Related Products</h2>
            <span class="title-leaf">
                <svg class="icon-width">
                    <use xlink:href="{!! asset('assets/svg/leaf.svg') !!}#leaf"></use>
                </svg>
            </span>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="slider-6_1 product-wrapper">
                    @foreach ($relatedProducts as $product)
                        @include('app.product-list-item', [$product])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@push('script')
<script>
    $(document).on("click", ".select-packege a", function() {
        var $this = $(this);
        var effectivePrice = $this.data('effective-price');
        var originalPrice = $this.data('original-price');
        var discount = $this.data('discount');
        var selectedPriceId = $this.data('price-id');

        // Update the price display
        var priceHtml = formatCurrency(effectivePrice);
        if (discount > 0) {
            priceHtml += '<del class="text-content">' + formatCurrency(originalPrice) + '</del>';
        }
        $('.price-rating .price').html(priceHtml);

        // Update the selectedPriceId in the hidden input
        $('#selectedPriceId').val(selectedPriceId);

        // Update the active class for the selected package
        $('.select-packege a').removeClass('active');
        $this.addClass('active');
    });
</script>
@endpush
@endsection
