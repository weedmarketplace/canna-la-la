@extends('app.layouts.app')
@section('content')

@if($sliders && count($sliders) > 0)
<!-- Poster Section Start -->
<section>
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="slider-1 slider-animate product-wrapper no-arrow">
                    @foreach($sliders as $slider)
                    <div>
                        <div class="home-contain rounded-0 p-0">
                            <img src="{{$slider->imagePath}}" class="img-fluid bg-img blur-up lazyload" alt="{{$slider->title}}">
                            <div class="home-detail home-big-space p-center-left position-relative">
                                <div class="container-fluid-lg">
                                    <div>
                                        <h6 class="ls-expanded theme-color text-uppercase">{{$slider->title}}</h6>
                                        @if($slider->description)
                                        <h1 class="heding-2">{{$slider->description}}</h1>
                                        @endif
                                        <button class="btn theme-bg-color btn-md text-white fw-bold mt-md-4 mt-2 mend-auto"
                                            @if($slider->linkType == 0) onclick="location.href = '{{$slider->link}}';" @else onclick="window.open('{{$slider->link}}', '_blank');" @endif >
                                            @if($slider->button_title){{$slider->button_title}} @else Shop Now @endif
                                            <i class="fa-solid fa-arrow-right icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Poster Section End -->
@endif

<!-- product section start -->
<section class="section-b-space">
    <div class="container-fluid-lg">
        <div class="row">
            @if($sidebarExist)
                @include('app.blocks.sidebar')
            @endif
            <div class="{{$sidebarExist ? 'col-xxl-9 col-lg-8' : 'col-xxl-12 col-lg-12'}}">
                @if($featuredProducts && count($featuredProducts) > 0)
                <div class="title d-block">
                    <h2 class="text-theme font-sm">Featured products</h2>
                    <!-- <p>A virtual assistant collects the products from your list</p> -->
                </div>
                <div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section section-b-space">
                <!-- <div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-md-3 row-cols-2 g-sm-4 g-3 no-arrow section-b-space"> -->
                    @foreach($featuredProducts as $productItem)
                        @include('app.product-list-item', ['product'=>$productItem])
                    @endforeach
                </div>
                @endif
                @if(isset($dealsArray[2]) && count($dealsArray[2]) > 0)
                    @foreach($dealsArray[2] as $deal)
                        <div class="banner-contain">
                            <img src="{{asset('images/homeMiddel/'.$deal->img)}}" class="bg-img blur-up lazyload" alt="">
                            <div class="banner-details p-center p-4 text-white text-center">
                                <div>
                                    <h3 class="lh-base fw-bold offer-text">{{$deal->title}}</h3>
                                    <h6 class="coupon-code">Use Code : {{$deal->code}}</h6>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if($popProducts && count($popProducts) > 0)
                <div class="title d-block section-t-space">
                    <h2 class="text-theme font-sm">Top selling</h2>
                    <!-- <p>A virtual assistant collects the products from your list</p> -->
                </div>
                <div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section section-b-space">
                <!-- <div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-md-3 row-cols-2 g-sm-4 g-3 no-arrow section-b-space"> -->
                    @foreach($popProducts as $productItem)
                        @include('app.product-list-item', ['product'=>$productItem])
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@if($featuredBlog && count($featuredBlog) > 0)
<!-- Blog Section Start -->
<section class="section-b-space">
    <div class="container-fluid-lg">
        <div class="title">
            <h2>Featured Blog</h2>
            <span class="title-leaf">
                <svg class="icon-width">
                    <use xlink:href="{{asset('assets/svg/leaf.svg')}}#leaf"></use>
                </svg>
            </span>
            <!-- <p>A virtual assistant collects the products from your list</p> -->
        </div>
        <div class="row">
            <div class="col-12">
                <div class="slider-5 ratio_87">
                    @foreach($featuredBlog as $blog)
                    <div>
                        <div class="blog-box">
                            <div class="blog-box-image">
                                <a href="{{ route('blogItem', ['slug'=>$blog->slug])}}" class="blog-image">
                                    <img src="{{asset('images/blogItem/'.$blog->img)}}" class="bg-img blur-up lazyload"
                                        alt="{{$blog->title}}">
                                </a>
                            </div>
                            <a href="{{ route('blogItem', ['slug'=>$blog->slug])}}" class="blog-detail">
                                <h6>{{ date('d M, Y', strtotime($blog->published_at))}}</h6>
                                <h5>{{$blog->title}}</h5>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->
@endif
<!-- product section end -->
@endsection
