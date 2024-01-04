<!DOCTYPE html>
<html lang="en">

<head>
    @include('app.blocks.meta')
    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- bootstrap css -->
    <link id="rtl-link" rel="stylesheet" type="text/css" href="{!! asset('assets/css/vendors/bootstrap.css') !!}">

    <!-- wow css -->
    <link rel="stylesheet" href="{!! asset('assets/css/animate.min.css') !!}" />

    <!-- font-awesome css -->
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/vendors/font-awesome.css') !!}">

    <!-- feather icon css -->
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/vendors/feather-icon.css') !!}">

    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/vendors/slick/slick.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/vendors/slick/slick-theme.css') !!}">

    <!-- Iconly css -->
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/bulk-style.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/vendors/animate.css') !!}">

    <!-- Template css -->
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/style.css') !!}?v2">
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/custom.css') !!}">
</head>

<body class="bg-effect">

    <!-- Loader Start -->
    <div class="fullpage-loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <!-- Loader End -->

    @include('app.age_verification')

    <!-- Header Start -->
    <header class="pb-md-4 pb-0">
        <div class="header-top">
            <div class="container-fluid-lg">
                <div class="row">
                    @if(isset($adminConfig['phone']))
                    <div class="col-xxl-3 d-xxl-block d-none">
                        <div class="top-left-header">
                            <i class="iconly-Call icli text-white"></i>
                            <span class="text-white">{{$adminConfig['phone']}}</span>
                        </div>
                    </div>
                    @endif
                    <div class="col-xxl-6 col-lg-9 d-lg-block d-none">
                        <div class="header-offer">
                            <div class="notification-slider">
                                <div>
                                    <div class="timer-notification">
                                        <h6>
                                            @if($topDeal)
                                                {{$topDeal->title}}<strong class="ms-1">New Coupon Code: {{$topDeal->code}}</strong>
                                            @endif
                                        </h6>
                                    </div>
                                </div>

                                <div>
                                    <div class="timer-notification">
                                        <h6>Something you love is now on sale! <a href="{{route('shop')}}" class="text-white">Buy Now!</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="top-nav top-header sticky-header">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-12">
                        <div class="navbar-top">
                            <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                                <span class="navbar-toggler-icon">
                                    <i class="fa-solid fa-bars"></i>
                                </span>
                            </button>
                            <a href="{{route('homepage')}}" class="web-logo nav-logo">
                                <img src="{!! asset('assets/images/logo-main.svg') !!}" id="header-logo" class="img-fluid blur-up lazyload" alt="">
                            </a>

                            <div class="middle-box">
                                <form id="searchForm">
                                    <div class="search-box">
                                        <div class="input-group">
                                            <input id="searchInput" action="{{ route('search') }}" type="search" class="form-control" placeholder="I'm searching for..."
                                                aria-label="Recipient's username" aria-describedby="button-addon2">
                                            <button class="btn" type="submit" id="button-addon2">
                                                <i data-feather="search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="rightside-box">
                                <form id="searchFormSmall">
                                    <div class="search-full">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i data-feather="search" class="font-light"></i>
                                            </span>
                                            <input id="searchInputSmall" action="{{ route('search') }}" type="text" class="form-control search-type" placeholder="Search here..">
                                            <span class="input-group-text close-search">
                                                <i data-feather="x" class="font-light"></i>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                                <ul class="right-side-menu">
                                    <li class="right-side">
                                        <div class="delivery-login-box">
                                            <div class="delivery-icon">
                                                <div class="search-box">
                                                    <i data-feather="search"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="right-side">
                                        <a href="{{ route('contact') }}" style="cursor:pointer" class="delivery-login-box">
                                            <div class="delivery-icon">
                                                <i data-feather="phone-call"></i>
                                            </div>
                                            <div class="delivery-detail">
                                                <h6>24/7 Delivery</h6>
                                                @if(isset($adminConfig['phone']))
                                                <h5>{{$adminConfig['phone']}}</h5>
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                    <li class="right-side">
                                        <a href="{{route('wishlist')}}" class="btn p-0 position-relative header-wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li>
                                    <li class="right-side">
                                        <div class="onhover-dropdown header-badge @if($cartData['count'] == 0) empty-cart @endif">
                                            <button type="button" class="btn p-0 position-relative header-wishlist">
                                                <i data-feather="shopping-cart"></i>
                                                <span class="position-absolute top-0 start-100 translate-middle badge" id="mainCartCount">{{$cartData['count']}}</span>
                                                    <!-- <span class="visually-hidden">unread messages</span> -->
                                            </button>

                                            <div class="onhover-div">
                                                <ul class="cart-list" id="mainCartList">
                                                    {!!$cartData['html']!!}
                                                </ul>

                                                <div class="price-box">
                                                    <h5>Total :</h5>
                                                    <h4 class="theme-color fw-bold" id="mainCartTotal">${{$cartData['total']}}</h4>
                                                </div>

                                                <div class="button-group">
                                                    <a href="{{route('cart')}}" class="btn btn-sm cart-button">View Cart</a>
                                                    <a href="{{route('checkout')}}" class="btn btn-sm cart-button theme-bg-color
                                                    text-white">Checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="right-side onhover-dropdown">
                                        <div class="delivery-login-box">
                                            <div class="delivery-icon">
                                                <a href="{{Auth::guard('web')->check() ? route('account') : route('sign-in') }}">
                                                    <i data-feather="user"></i>
                                                </a>
                                            </div>
                                            @if(Auth::guard('web')->check())
                                            <div class="delivery-detail">
                                                <h6>Hello, <span id="headerFullname">{{ Auth::guard('web')->user()->name }}</span></h6>
                                                <h5>My Account</h5>
                                            </div>
                                            @endif
                                        </div>
                                        <!-- <div class="onhover-div onhover-div-login">
                                            <ul class="user-box-name">
                                                <li class="product-box-contain">
                                                    <i></i>
                                                    <a href="login.html">Log In</a>
                                                </li>

                                                <li class="product-box-contain">
                                                    <a href="sign-up.html">Register</a>
                                                </li>

                                                <li class="product-box-contain">
                                                    <a href="forgot.html">Forgot Password</a>
                                                </li>
                                            </ul>
                                        </div> -->
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="header-nav">
                        @if($nestedCollections && count($nestedCollections) > 0)
                            <div class="header-nav-left">
                                <button class="dropdown-category">
                                    <i data-feather="align-left"></i>
                                    <span>All Categories</span>
                                </button>

                                <div class="category-dropdown">
                                    <div class="category-title">
                                        <h5>Categories</h5>
                                        <button type="button" class="btn p-0 close-button text-content">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>

                                    <ul class="category-list">
                                    @foreach($nestedCollections as $topCategory)
                                        
                                            <li class="onhover-category-list">
                                                <a href="{{ route('shop', ['slug'=>$topCategory->slug]) }}" class="category-name">
                                                    @if($topCategory->image)
                                                        <img src="{{ asset('content/'.$topCategory->image) }}" alt="{{ $topCategory->title }}">
                                                    @endif
                                                    <h6>{{ $topCategory->title }}</h6>
                                                    <i class="fa-solid fa-angle-right"></i>
                                                </a>
                                                @if($topCategory->children && count($topCategory->children) > 0)
                                                    @php
                                                        $totalSubItems = collect($topCategory->children)->sum(function ($child) {
                                                            return count($child->children ?? []) + 1;
                                                        });
                                                        $halfwayPoint = $totalSubItems > 10 ? ceil($totalSubItems / 2) : $totalSubItems;
                                                        $firstHalf = [];
                                                        $secondHalf = [];
                                                        $currentItemCount = 0;

                                                        foreach ($topCategory->children as $subCategory) {
                                                            if ($currentItemCount < $halfwayPoint) {
                                                                $firstHalf[] = $subCategory;
                                                            } else {
                                                                $secondHalf[] = $subCategory;
                                                            }
                                                            $currentItemCount += count($subCategory->children ?? []) + 1;
                                                        }
                                                    @endphp
                                                    <div class="onhover-category-box {{$totalSubItems < 10 ? 'w-100' : ''}}">
                                                        <div class="list-1">
                                                            <ul>
                                                                @foreach($firstHalf as $subCategory)
                                                                    @include('app.blocks.sub_items', ['subCategory' => $subCategory])
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                        {{-- Only render list-2 if there are more than 10 items --}}
                                                        @if($totalSubItems > 10)
                                                            <div class="list-2">
                                                                <ul>
                                                                    @foreach($secondHalf as $subCategory)
                                                                        @include('app.blocks.sub_items', ['subCategory' => $subCategory])
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <div class="header-nav-middle">
                            <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                                <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                    <div class="offcanvas-header navbar-shadow">
                                        <h5>Menu</h5>
                                        <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link removeBefore" href="{{route('homepage')}}">Home</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link removeBefore" href="{{route('shop')}}">Shop</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link removeBefore" href="{{route('blog')}}">Blog</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="header-nav-right">
                            <button class="btn deal-button" data-bs-toggle="modal" data-bs-target="#deal-box">
                                <i data-feather="zap"></i>
                                <span>Deal Today</span>
                            </button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        
    </header>
    <!-- Header End -->

    <!-- mobile fix menu start -->
    <!-- TODO: MObile menu-->
    <div class="mobile-menu d-md-none d-block mobile-cart">
        <ul>
            <li class="{{isset($menu) && $menu == 'home' ? 'active' : ''}}">
                <a href="{{route('homepage')}}">
                    <i class="iconly-Home icli"></i>
                    <span>Home</span>
                </a>
            </li>

            <li class="mobile-category">
                <a href="javascript:void(0)">
                    <i class="iconly-Category icli js-link"></i>
                    <span>Category</span>
                </a>
            </li>

            <li class="{{isset($menu) && $menu == 'search' ? 'active' : ''}}">
                <a href="{{route('search')}}" class="search-box">
                    <i class="iconly-Search icli"></i>
                    <span>Search</span>
                </a>
            </li>

            <li class="{{isset($menu) && $menu == 'wishlist' ? 'active' : ''}}">
                <a href="{{route('wishlist')}}">
                    <i class="iconly-Heart icli"></i>
                    <span>My Wish</span>
                </a>
            </li>

            <li class="{{isset($menu) && $menu == 'cart' ? 'active' : ''}}">
                <a href="{{route('cart')}}">
                    <i class="iconly-Bag-2 icli fly-cate"></i>
                    <span>Cart</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- mobile fix menu end -->
    @if(isset($breadscrumbData))
        @include('app.blocks.breadscrumb',['breadscrumb'=>$breadscrumbData])
    @endif
    @yield('content')

    <footer class="">
        <div class="container-fluid-lg">
            <?php /*
            <div class="service-section">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="service-contain">
                            <div class="service-box">
                                <div class="service-image">
                                    <img src="{!! asset('assets/svg/product.svg') !!}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>Every Fresh Products</h5>
                                </div>
                            </div>

                            <div class="service-box">
                                <div class="service-image">
                                    <img src="{!! asset('assets/svg/delivery.svg') !!}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>Free Delivery For Order Over $50</h5>
                                </div>
                            </div>

                            <div class="service-box">
                                <div class="service-image">
                                    <img src="{!! asset('assets/svg/discount.svg') !!}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>Daily Mega Discounts</h5>
                                </div>
                            </div>

                            <div class="service-box">
                                <div class="service-image">
                                    <img src="{!! asset('assets/svg/market.svg') !!}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>Best Price On The Market</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            */ ?>
            <div class="main-footer section-b-space section-t-space border-top-0">
                <div class="row g-md-4 g-3">
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="footer-logo">
                            <div class="theme-logo">
                                <a href="{{route('homepage')}}">
                                    <img src="{!! asset('assets/images/logo-main.svg') !!}" id="footer-logo" class="blur-up lazyload" alt="Canna-la-la.com">
                                </a>
                            </div>

                            <div class="footer-logo-contain">
                                <p>Welcome to {{ env('APP_NAME') }}, your go-to source for premium cannabis products.</p>
                                
                                @if(isset($adminConfig['email']))
                                <ul class="address">
                                    <!-- <li>
                                        <i data-feather="home"></i>
                                        <a href="javascript:void(0)">1418 Riverwood Drive, CA 96052, US</a>
                                    </li> -->
                                    <li>
                                        <i data-feather="mail"></i>
                                        <a href="javascript:void(0)">{{$adminConfig['email']}}</a>
                                    </li>
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($nestedCollections && count($nestedCollections) > 0)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="footer-title">
                            <h4>Categories</h4>
                        </div>

                        <div class="footer-contain">
                            <ul>
                                @foreach($nestedCollections as $topCategory)
                                <li>
                                    <a href="{{ route('shop', ['slug'=>$topCategory->slug]) }}" class="text-content">{{$topCategory->title}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div class="col-xl col-lg-2 col-sm-3">
                        <div class="footer-title">
                            <h4>Useful Links</h4>
                        </div>

                        <div class="footer-contain">
                            <ul>
                                <li>
                                    <a href="{{ route('homepage') }}" class="text-content">Home</a>
                                </li>
                                <li>
                                    <a href="{{ route('shop') }}" class="text-content">Shop</a>
                                </li>
                                <li>
                                    <a href="{{ route('blog') }}" class="text-content">Blog</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}" class="text-content">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-2 col-sm-3">
                        <div class="footer-title">
                            <h4>Help Center</h4>
                        </div>

                        <div class="footer-contain">
                            <ul>
                                <li>
                                    <a href="{{Auth::guard('web')->check() ? route('account') : route('sign-in') }}" class="text-content">Your Account</a>
                                </li>
                                <li>
                                    <a href="{{route('wishlist')}}" class="text-content">Your Wishlist</a>
                                </li>
                                <li>
                                    <a href="{{route('search')}}" class="text-content">Search</a>
                                </li>
                                <li>
                                    <a href="{{route('terms')}}" class="text-content">Terms and conditions</a>
                                </li>
                                <li>
                                    <a href="{{route('privacy')}}" class="text-content">Privacy policy</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        @if(isset($adminConfig['phone']) || isset($adminConfig['email']))
                        <div class="footer-title">
                            <h4>Contact Us</h4>
                        </div>

                        <div class="footer-contact">
                            <ul>
                                @if(isset($adminConfig['phone']))
                                <li>
                                    <div class="footer-number">
                                        <i data-feather="phone"></i>
                                        <div class="contact-number">
                                            <h6 class="text-content">Hotline 24/7 :</h6>
                                            <h5>{{$adminConfig['phone']}}</h5>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if(isset($adminConfig['email']))
                                <li>
                                    <div class="footer-number">
                                        <i data-feather="mail"></i>
                                        <div class="contact-number">
                                            <h6 class="text-content">Email Address :</h6>
                                            <h5>{{$adminConfig['email']}}</h5>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="sub-footer section-small-space">
                <div class="reserve">
                    <h6 class="text-content">Cannabis products listed on our website are not for use by or sale to persons under the age of 21. All products should be used only as directed on the label. Cannabis products should not be used if you are pregnant or nursing. Consult with a physician before use if you have a serious medical condition or use prescription medications. A Doctor’s advice should be sought before using this and any supplemental dietary product. All trademarks and copyrights are property of their respective owners and are not affiliated with nor do they endorse these products. These statements have not been evaluated by the FDA. No product is intended to diagnose, treat, cure or prevent any disease. By using this site, you agree to follow the Privacy Policy and all Terms & Conditions printed on this site. Void Where Prohibited by Law.</h6>
                </div>
            </div>
            <div class="sub-footer section-small-space">
                <div class="reserve">
                    <h6 class="text-content">©<?php echo date("Y"); ?> {{ env('APP_NAME') }} All rights reserved</h6>
                </div>
                @if(isset($adminConfig['facebook']) || isset($adminConfig['twitter']) || isset($adminConfig['instagram']) || isset($adminConfig['pinterest']))
                <div class="social-link">
                    <h6 class="text-content">Stay connected :</h6>
                    <ul>
                        @if(isset($adminConfig['facebook']))
                        <li>
                            <a href="{{$adminConfig['facebook']}}" target="_blank">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                        @endif
                        @if(isset($adminConfig['twitter']))
                        <li>
                            <a href="{{$adminConfig['twitter']}}" target="_blank">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li>
                        @endif
                        @if(isset($adminConfig['instagram']))
                        <li>
                            <a href="{{$adminConfig['instagram']}}" target="_blank">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                        @endif
                        @if(isset($adminConfig['pinterest']))
                        <li>
                            <a href="{{$adminConfig['pinterest']}}" target="_blank">
                                <i class="fa-brands fa-pinterest-p"></i>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Quick View Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="view" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="selectedPriceId" value="">
                    <input type="hidden" id="viewProductId" value="">
                    <div class="row g-sm-4 g-2">
                        <div class="col-lg-6">
                            <div class="slider-image">
                                <img src="{!! asset('assets/images/nib.png') !!}" class="img-fluid blur-up lazyload"
                                    alt="">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="right-sidebar-modal">
                                <h4 class="title-name"></h4>
                                <h4 class="price"></h4>
                                <!-- <div class="product-rating">
                                    <ul class="rating">
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star"></i>
                                        </li>
                                    </ul>
                                    <span class="ms-2">8 Reviews</span>
                                    <span class="ms-2 text-danger">6 sold in last 16 hours</span>
                                </div> -->

                                <div class="product-detail">
                                    <h4>Product Details :</h4>
                                    <p class="product_descirption"></p>
                                </div>

                                <ul class="brand-list">
                                    <li>
                                        <div class="brand-box">
                                            <h5>Category:</h5>
                                            <h6 class="category_title"></h6>
                                        </div>
                                    </li>
                                    <li id="strain_container">
                                        <div class="brand-box">
                                            <h5>Strain:</h5>
                                            <h6 class="strain_title"></h6>
                                        </div>
                                    </li>
                                    <li id="genetic_container">
                                        <div class="brand-box">
                                            <h5>Genetic:</h5>
                                            <h6 class="genetic_title"></h6>
                                        </div>
                                    </li>             
                                    <li id="cannabinoid_container">
                                        <div class="brand-box">
                                            <h5>Cannabinoid:</h5>
                                            <h6 class="cannabinoid_title"></h6>
                                        </div>
                                    </li>             
                                    <!-- <li>
                                        <div class="brand-box">
                                            <h5>Product Code:</h5>
                                            <h6>W0690034</h6>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="brand-box">
                                            <h5>Product Type:</h5>
                                            <h6>White Cream Cake</h6>
                                        </div>
                                    </li> -->
                                </ul>

                                <div class="select-size">
                                    <h4>Weight: </h4>
                                    <select class="form-select select-form-size">
                                        <option selected>Select Size</option>
                                    </select>
                                </div>

                                <div class="select-size-label"></div>

                                <div class="modal-button">
                                    <button class="btn btn-md add-cart-button popupView icon">Add To Cart</button>
                                    <button class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                        View More Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Box End -->

    <?php /*
    <!-- Location Modal Start -->
    <div class="modal location-modal fade theme-modal" id="locationModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Choose your Delivery Location</h5>
                    <p class="mt-1 text-content">Enter your address and we will specify the offer for your area.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="location-list">
                        <div class="search-input">
                            <input type="search" class="form-control" placeholder="Search Your Area">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>

                        <div class="disabled-box">
                            <h6>Select a Location</h6>
                        </div>

                        <ul class="location-select custom-height">
                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Alabama</h6>
                                    <span>Min: $130</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Arizona</h6>
                                    <span>Min: $150</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>California</h6>
                                    <span>Min: $110</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Colorado</h6>
                                    <span>Min: $140</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Florida</h6>
                                    <span>Min: $160</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Georgia</h6>
                                    <span>Min: $120</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Kansas</h6>
                                    <span>Min: $170</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Minnesota</h6>
                                    <span>Min: $120</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>New York</h6>
                                    <span>Min: $110</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Washington</h6>
                                    <span>Min: $130</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Location Modal End -->

    <!-- Cookie Bar Box Start -->
    <!-- <div class="cookie-bar-box">
        <div class="cookie-box">
            <div class="cookie-image">
                <img src="../assets/images/cookie-bar.png" class="blur-up lazyload" alt="">
                <h2>Cookies!</h2>
            </div>

            <div class="cookie-contain">
                <h5 class="text-content">We use cookies to make your experience better</h5>
            </div>
        </div>

        <div class="button-group">
            <button class="btn privacy-button">Privacy Policy</button>
            <button class="btn ok-button">OK</button>
        </div>
    </div> -->
    <!-- Cookie Bar Box End -->

    <!-- Deal Box Modal Start -->
    <div class="modal fade theme-modal deal-modal" id="deal-box" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title w-100" id="deal_today">Deal Today</h5>
                        <p class="mt-1 text-content">Recommended deals for you.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="deal-offer-box">
                        <ul class="deal-offer-list">
                            <li class="list-1">
                                <div class="deal-offer-contain">
                                    <a href="shop-left-sidebar.html" class="deal-image">
                                        <img src="../assets/images/vegetable/product/10.png" class="blur-up lazyload"
                                            alt="">
                                    </a>

                                    <a href="shop-left-sidebar.html" class="deal-contain">
                                        <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>
                                        <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>
                                    </a>
                                </div>
                            </li>

                            <li class="list-2">
                                <div class="deal-offer-contain">
                                    <a href="shop-left-sidebar.html" class="deal-image">
                                        <img src="../assets/images/vegetable/product/11.png" class="blur-up lazyload"
                                            alt="">
                                    </a>

                                    <a href="shop-left-sidebar.html" class="deal-contain">
                                        <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>
                                        <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>
                                    </a>
                                </div>
                            </li>

                            <li class="list-3">
                                <div class="deal-offer-contain">
                                    <a href="shop-left-sidebar.html" class="deal-image">
                                        <img src="../assets/images/vegetable/product/12.png" class="blur-up lazyload"
                                            alt="">
                                    </a>

                                    <a href="shop-left-sidebar.html" class="deal-contain">
                                        <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>
                                        <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>
                                    </a>
                                </div>
                            </li>

                            <li class="list-1">
                                <div class="deal-offer-contain">
                                    <a href="shop-left-sidebar.html" class="deal-image">
                                        <img src="../assets/images/vegetable/product/13.png" class="blur-up lazyload"
                                            alt="">
                                    </a>

                                    <a href="shop-left-sidebar.html" class="deal-contain">
                                        <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>
                                        <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Deal Box Modal End -->
    
    */?>
    <!-- Tap to top start -->
    <div class="theme-option">
        <div class="back-to-top">
            <a id="back-to-top" href="#">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <!-- Tap to top end -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->

    <!-- latest jquery-->
    <script src="{!! asset('assets/js/jquery-3.6.0.min.js') !!}"></script>

    <!-- jquery ui-->
    <script src="{!! asset('assets/js/jquery-ui.min.js') !!}"></script>

    <!-- Bootstrap js-->
    <script src="{!! asset('assets/js/bootstrap/bootstrap.bundle.min.js') !!}"></script>
    <script src="{!! asset('assets/js/bootstrap/bootstrap-notify.min.js') !!}"></script>
    <script src="{!! asset('assets/js/bootstrap/popper.min.js') !!}"></script>

    <!-- feather icon js-->
    <script src="{!! asset('assets/js/feather/feather.min.js') !!}"></script>
    <script src="{!! asset('assets/js/feather/feather-icon.js') !!}"></script>

    <!-- Lazyload Js -->
    <script src="{!! asset('assets/js/lazysizes.min.js') !!}"></script>

    <!-- Slick js-->
    <script src="{!! asset('assets/js/slick/slick.js') !!}"></script>
    <script src="{!! asset('assets/js/slick/slick-animation.min.js') !!}"></script>
    <script src="{!! asset('assets/js/slick/custom_slick.js') !!}"></script>

    <!-- Auto Height Js -->
    <script src="{!! asset('assets/js/auto-height.js') !!}"></script>

    <!-- Timer Js -->
    <!-- <script src="{!! asset('assets/js/timer1.js') !!}"></script> -->

    <!-- Fly Cart Js -->
    <script src="{!! asset('assets/js/fly-cart.js') !!}"></script>

    <!-- Quantity js -->
    <script src="{!! asset('assets/js/quantity-2.js') !!}"></script>

    <!-- WOW js -->
    <script src="{!! asset('assets/js/wow.min.js') !!}"></script>
    <script src="{!! asset('assets/js/custom-wow.js') !!}"></script>

    <!-- script js -->
    <script src="{!! asset('assets/js/script.js') !!}"></script>
    <script src="{!! asset('assets/js/custom.js') !!}"></script>
    <script src="{!! asset('assets/js/validate.js') !!}"></script>
    @stack('script')
    <script>
    document.getElementById('searchFormSmall').addEventListener('submit', function(event) {
        event.preventDefault();
        var searchText = document.getElementById('searchInputSmall').value;
        // Construct the URL for redirection
        window.location.href = '{{ route("search") }}?q=' + encodeURIComponent(searchText);
    });
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var searchText = document.getElementById('searchInput').value;
        // Construct the URL for redirection
        window.location.href = '{{ route("search") }}?q=' + encodeURIComponent(searchText);
    });
    $(document).ready(function() {
        $( document ).on( "click", ".view-product-link", function(event) {
            event.preventDefault();

            var productId = $(this).parent().data('product-id');

            $.ajax({
                url: "{{route('getProduct')}}",
                method: 'GET',
                data: { id: productId },
                success: function(response) {
                    $('#view .slider-image img').attr('src', response.imagePath);
                    $('#view .title-name').text(response.title);
                    $('#view .product_descirption').text(response.description);
                    $('#view .category_title').text(response.category_title);
                    if(response.strain){
                        $('#view .strain_title').text(response.strain);
                        $('#view #strain_container').show();
                    }else{
                        $('#view #strain_container').hide();
                    }
                    if(response.genetic){
                        $('#view .genetic_title').text(response.genetic);
                        $('#view #genetic_container').show();
                    }else{
                        $('#view #genetic_container').hide();
                    }
                    if(response.cannabinoid){
                        $('#view .cannabinoid_title').text(response.cannabinoid);
                        $('#view #cannabinoid_container').show();
                    }else{
                        $('#view #cannabinoid_container').hide();
                    }

                    if(response.discount > 0){
                        $('#view .price').text('$ ' + response.effective_price);
                        $('#view .price').append('<del>$ ' + response.price + '</del>');
                    } else {
                        $('#view .price').text('$ ' + response.price);
                        $('#view .price del').remove();
                    }

                    $('#view .select-size .select-form-size').empty();
                    $('#view .select-size .select-form-size').off('change');
                    $('#view .select-size-label').hide().text('');
                    $('#view .select-size h4').show();
                    $('#view .view-button').attr('onclick', "location.href = '" + response.route + "';");
                    $('#view #viewProductId').val(response.id);
                    
                    const selectSizeElem = $('#view .select-size .select-form-size');
                    if(response.pricing_type === 'by_weight' && response.prices_by_weight) {
                        if(response.prices_by_weight.length > 1) {
                            selectSizeElem.empty();

                            let minPriceFound = false;
                            response.prices_by_weight.forEach(priceObj => {
                                const optionElem = $('<option></option>')
                                    .val(priceObj.effective_price)
                                    .text(priceObj.unit)
                                    .data('original-price', priceObj.price)
                                    .data('price-id', priceObj.price_id);
                                selectSizeElem.append(optionElem);

                                if(priceObj.price_id === response.price_id) {
                                    optionElem.attr('selected', 'selected');
                                    minPriceFound = true;
                                }
                            });

                            if(!minPriceFound) {
                                selectSizeElem.prepend($('<option>Select Size</option>').attr('selected', 'selected'));
                            }

                            selectSizeElem.change(function() {
                                const newSelectedEffectivePrice = parseFloat($(this).val());
                                const originalPrice = $(this).find('option:selected').data('original-price');
                                const selectedPriceId = $(this).find('option:selected').data('price-id'); // Get price_id from selected option

                                $('#view #selectedPriceId').val(selectedPriceId);

                                // Clear the price container first
                                $('#view .price').empty();

                                // Check if there is a discount
                                if (newSelectedEffectivePrice < originalPrice) {
                                    $('#view .price').text('$ ' + newSelectedEffectivePrice).append('<del>$ ' + originalPrice + '</del>');
                                } else {
                                    $('#view .price').text('$ ' + originalPrice);
                                }
                            });

                            const selectedOption = selectSizeElem.find('option:selected');
                            if (selectedOption.length) {
                                $('#view #selectedPriceId').val(selectedOption.data('price-id'));
                            } else {
                                $('#view #selectedPriceId').val(selectSizeElem.find('option:first').data('price-id'));
                            }

                            selectSizeElem.show();
                            $('#view .select-size h4').show();
                        } else {
                            const size = response.prices_by_weight[0].unit;
                            const price_id = response.prices_by_weight[0].price_id;
                            selectSizeElem.hide();
                            $('#view .select-size h4').hide();
                            $('#view .select-size-label').text('Weight: ' + size).show();
                            $('#view #selectedPriceId').val(price_id);
                        }
                    } else {
                        const size = response.unit;
                        selectSizeElem.hide();
                        $('#view .select-size h4').hide();
                        $('#view .select-size-label').text('Weight: ' + size).show();
                        $('#view #selectedPriceId').val(response.price_id);
                    }

                    $('#view').modal('show');
                },
                error: function() {
                    alert("Failed to fetch product details!");
                }
            });
        });

        $( document ).on( "click", ".btn-apply", function(e) {
            e.preventDefault();
            btn = $('.btn-apply');
            
            $('#coupon_error_con').html('');
            var couponCode = $('#couponCode').val();
            if(couponCode == ''){
                $('#coupon_error_con').html('Please enter coupon code');
                return false;
            }
            var formData = new FormData();
            formData.append('couponCode',couponCode);

            Loading.add(btn);
            $.ajax({
                url: "{{ route('applyCoupon') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    console.log(response)
                    if(response.status == 1){
                        Loading.remove(btn);
                        $('#couponCode').val('');
                        
                        $('#couponDiscount').data('type', response.couponData.type);
                        if(response.couponData.type == 'fixed'){
                            $('#couponDiscount').data('size', response.couponData.amount);
                        }
                        if(response.couponData.type == 'percent'){
                            $('#couponDiscount').data('size', response.couponData.percent);
                        }
                        if (isCartPage() || isCheckoutPage()) {
                            var page = isCartPage() ? '#cartPageIdentifier' : '#checkoutPageIdentifier';
                            updateCartView(page);
                        }
                    }
                },
                error: function(response) {
                    Loading.remove(btn);
                    if(response.responseJSON.error){
                        error = response.responseJSON.error;
                        $('#coupon_error_con').html(error);
                    }
                    return;
                }
            });
        });

        // ADDTOCART
        $( document ).on( "click", ".addcart-button, .qty-right-plus", function(e) {
            e.preventDefault();
            if($(this).hasClass('product-page-btn')){
                return;
            }
            var productId = $(this).data('product-id');
            var priceId = $(this).data('price-id');
            var submitButton = $(this);
            addToCart(submitButton,productId, priceId);
        });

        $( document ).on( "click", "#view .add-cart-button", function(e) {
            e.preventDefault();
            var productId = $('#view #viewProductId').val();
            var priceId = $('#view #selectedPriceId').val();
            var submitButton = $(this);
            addToCart(submitButton,productId, priceId);
        });

        $( document ).on( "click", "#productPage .add-cart-button", function(e) {
            e.preventDefault();
            var productId = $('#productPage #mainProductId').val();
            var priceId = $('#productPage #selectedPriceId').val();
            var mainQty = $('#productPage #mainQty').val();
            var submitButton = $(this);
            addToCart(submitButton,productId, priceId , mainQty);
        });

        $( document ).on( "click", ".remove-product, .qty-left-minus", function(e) {
            e.preventDefault();
            if($(this).hasClass('product-page-btn')){
                return;
            }
            var productId = $(this).data('product-id');
            var priceId = $(this).data('price-id');
            

            if($(this).hasClass('qty-left-minus')){
                removeFromCart(productId, priceId, false );
            }else{
                if (isCartPage()) {
                    var item = $('#cartPageIdentifier .product-box-contain').filter(function() {
                                return $(this).find('.remove-product').data('product-id') == productId &&
                                        $(this).find('.remove-product').data('price-id') == priceId;
                    });
                    item.addClass('removed-item');
                    item.fadeOut("slow", function() {
                        item.remove();
                    });
                }
                if (isCheckoutPage()) {
                    var item = $('.product-box-contain').filter(function() {
                        return $(this).data('product-id') == productId && $(this).data('price-id') == priceId;
                    });
                    item.addClass('removed-item');
                    item.fadeOut("slow", function() {
                        item.remove();
                    });
                }
                removeFromCart(productId, priceId, true );
            }
        });

        // Wishlist
        $( document ).on( "click", ".notifi-wishlist", function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            if($(this).hasClass('from-product-view')){
                var priceId = $('#productPage #selectedPriceId').val();
            }else{
                var priceId = $(this).data('price-id');
            }
            var submitButton = $(this);
            addToWishlist(submitButton,productId, priceId);
        });
        $( document ).on( "click", ".wishlist-button.close_button", function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            var priceId = $(this).data('price-id');
            removeFromWishlist(productId, priceId);
        });
    });

    function removeFromCart(productId, priceId, all = true) {
        var formData = new FormData();
        formData.append('productId',productId);
        formData.append('priceId', priceId);
        formData.append('all', all);
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            type: 'POST',
            url: "{{ route('remove-cart') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    // item.fadeOut("slow", function() {
                    //     item.remove();
                    // });
                    
                    updateCartUI(response.cartData);
                }else{
                    alert(response.message)
                }
            },
            error: function(response) {
                if(response.responseJSON.errors){
                    errors = response.responseJSON.errors
                    $.each( errors, function( key, value ) {
                        if(key == 'qty'){
                            $( ".qty-container" ).append( '<label class="error" style="position:absolute; bottom: 20px;">'+value+'</label>' );
                        }
                        if(key == 'server'){
                            alert(value)
                        }
                    });
                }
                return;
            }
        });
    }
    function addToCart(submitButton,productId, priceId , qty = 1) {

        var formData = new FormData();
        formData.append('productId',productId);
        formData.append('priceId', priceId);
        formData.append('qty', qty);
        
        // ADDTOCART ANIMATION
        var cartIcon = $('#mainCartCount');
        var btnPosition = submitButton.offset();
        var cartPosition = cartIcon.offset();
        var iconToFly = $('<div class="flying-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></div>');
        $('body').append(iconToFly);
        iconToFly.css({
            'left': btnPosition.left + 'px',
            'top': btnPosition.top + 'px'
        });
        var translateX = cartPosition.left - btnPosition.left;
        var translateY = cartPosition.top - btnPosition.top;
        iconToFly.css('animation', 'flyToCart 1s forwards').css('transform', `translate(${translateX}px, ${translateY}px) scale(0)`);
        // ADDTOCART ANIMATION END

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            type: 'POST',
            url: "{{ route('add-to-cart') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    updateCartUI(response.cartData);
                    if(submitButton.hasClass('popupView')){
                        $('#view').modal('hide');
                    }
                }else{
                    alert(response.message)
                }
            },
            error: function(response) {
                if(response.responseJSON.errors){
                    errors = response.responseJSON.errors
                    $.each( errors, function( key, value ) {
                        if(key == 'qty'){
                            $( ".qty-container" ).append( '<label class="error" style="position:absolute; bottom: 20px;">'+value+'</label>' );
                        }
                        if(key == 'server'){
                            alert(value)
                        }
                    });
                }
                return;
            }
        });
    }
    function updateCartUI(cartData) {
        $('#mainCartCount').html(cartData.count);
        $('#mainCartList').html(cartData.html);
        $('#mainCartTotal').html('$'+cartData.total);

        if (isCartPage() || isCheckoutPage()) {
            var page = isCartPage() ? '#cartPageIdentifier' : '#checkoutPageIdentifier';
            updateCartView(page);
        }

        if (cartData.count > 0) {
            $('.onhover-dropdown').removeClass('empty-cart');
        } else {
            $('.onhover-dropdown').addClass('empty-cart');
        }
    }
    function updateCartView(page){
        subTotal = 0;
        totalQty = 0;
        $(page  + ' .product-box-contain').each(function(i, obj) {
            if($(obj).hasClass('removed-item')){
                return;
            }
            if(page == '#cartPageIdentifier'){
                price = parseFloat($(obj).find('.sell_price').data('amount'));
                qty = parseInt($(obj).find('.qty-input').val())
            }
            if(page == '#checkoutPageIdentifier'){
                price = parseFloat($(obj).data('sell-price'));
                qty = parseInt($(obj).data('qty'));
            }
            if(qty < 1){
                $(obj).fadeOut("slow", function() {
                    $(obj).remove();
                });
            }else{
                productSubTotal = price * qty;
                subTotal += productSubTotal;
                currentSubTotal = parseFloat($(obj).find('.product_sub_total').html());
                if(currentSubTotal != productSubTotal){
                    $(obj).find('.product_sub_total').html(formatCurrency(productSubTotal));
                }
            }
        });

        if(subTotal == 0){
            window.location = "{{route('shop')}}";
            return
        }
        
        total = subTotal;
        var discountInput = $('#couponDiscount');
        if(discountInput.data('type') == 'fixed'){
            discountPirce = parseFloat(discountInput.data('size'));
            // discountPirce = discountPirce.toFixed(2);
            $('#couponDiscount').html(formatCurrency(discountPirce));
            total = total - discountPirce;
        }
        if(discountInput.data('type') == 'percent'){
            discountPirce = (total * discountInput.data('size')) / 100;
            // discountPirce = discountPirce.toFixed(2);
            $('#couponDiscount').html(formatCurrency(discountPirce));
            total = total - discountPirce;
        }
        
        tempTotal = total;
        if ($('#sales_tax').length > 0) {
            var salesTaxPercent = parseFloat($('#sales_tax').data('percent'));
            var salesTaxAmount = tempTotal * (salesTaxPercent / 100);
            // salesTaxAmount = parseFloat(salesTaxAmount.toFixed(2));
            $('#sales_tax').html(formatCurrency(salesTaxAmount));
            total = total + salesTaxAmount;
        }

        if ($('#excise_tax').length > 0) {
            var exciseTaxPercent = parseFloat($('#excise_tax').data('percent'));
            var exciseTaxAmount = tempTotal * (exciseTaxPercent / 100);
            // exciseTaxAmount = parseFloat(exciseTaxAmount.toFixed(2));
            $('#excise_tax').html(formatCurrency(exciseTaxAmount));
            total = total + exciseTaxAmount;
        }
        
        if($('#delivery_fee').length > 0){
            shippingPrice = parseFloat($('#delivery_fee').data('amount'));
            total = total + shippingPrice;
        }

        $('#mainSubTotal').html(formatCurrency(subTotal));
        $('#mainTotal').html(formatCurrency(total));
        $('#mainTotal').data('amount',total);
    }
    function formatCurrency(value) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        }).format(value);
    }
    function isCartPage() {
        return $('#cartPageIdentifier').length > 0;
    }
    function isCheckoutPage() {
        return $('#checkoutPageIdentifier').length > 0;
    }
    function addToWishlist(submitButton,productId, priceId) {
        var formData = new FormData();
        formData.append('productId',productId);
        formData.append('priceId', priceId);
        
        // ADDWishlist ANIMATION
        var wishlistIcon = $('.header-wishlist');
        var btnPosition = submitButton.offset();
        var wishlistPosition = wishlistIcon.offset();
        var iconToFly = $('<div class="flying-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></div>');
        $('body').append(iconToFly);
        iconToFly.css({
            'left': btnPosition.left + 'px',
            'top': btnPosition.top + 'px'
        });
        var translateX = wishlistPosition.left - btnPosition.left;
        var translateY = wishlistPosition.top - btnPosition.top;
        iconToFly.css('animation', 'flyToCart 1s forwards').css('transform', `translate(${translateX}px, ${translateY}px) scale(0)`);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            type: 'POST',
            url: "{{ route('add-to-wishlist') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    // updateCartUI(response.cartData);
                }else{
                    alert(response.message)
                }
            },
            error: function(response) {
                if(response.responseJSON.errors){
                    errors = response.responseJSON.errors
                    $.each( errors, function( key, value ) {
                        if(key == 'qty'){
                            $( ".qty-container" ).append( '<label class="error" style="position:absolute; bottom: 20px;">'+value+'</label>' );
                        }
                        if(key == 'server'){
                            alert(value)
                        }
                    });
                }
                return;
            }
        });
    }
    function removeFromWishlist(productId, priceId) {
        var formData = new FormData();
        formData.append('productId',productId);
        formData.append('priceId', priceId);
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            type: 'POST',
            url: "{{ route('remove-from-wishlist') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    $(".product-box-contain.wishlistItem").filter(function() {
                        return $(this).find('.wishlist-button').data('product-id') == productId &&
                            $(this).find('.wishlist-button').data('price-id') == priceId;
                    }).remove();
                }
            },
            error: function(response) {
                if(response.responseJSON.errors){
                    errors = response.responseJSON.errors
                    $.each( errors, function( key, value ) {
                        alert(value)
                    });
                }
                return;
            }
        });
    }
    </script>
</body>

</html>