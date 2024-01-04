@extends('app.layouts.app')
@section('content')
<!-- User Dashboard Section Start -->
<section class="user-dashboard-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-xxl-3 col-lg-4">
                <div class="dashboard-left-sidebar">
                    <div class="close-button d-flex d-lg-none">
                        <button class="close-sidebar">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="profile-box">
                        <div class="cover-image">
                            <img src="{{asset('assets/images/inner-page/cover-img.jpg')}}" class="img-fluid blur-up lazyload"
                                alt="">
                        </div>

                        <div class="profile-contain">
                            <div class="profile-name">
                                <h3 id="dashboard_name">{{ Auth::guard('web')->user()->name }}</h3>
                                <h6 id="dashboard_email" class="text-content">{{ Auth::guard('web')->user()->email }}</h6>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="true"><i data-feather="user"></i>
                                Profile</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-order-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                                aria-selected="false"><i data-feather="shopping-bag"></i>Order</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-wishlist-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-wishlist" type="button" role="tab"
                                aria-controls="pills-wishlist" aria-selected="false"><i data-feather="heart"></i>
                                Wishlist</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-address-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-address" type="button" role="tab"
                                aria-controls="pills-address" aria-selected="false"><i data-feather="map-pin"></i>
                                Address</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="text-decoration-none" href="{{route('logout')}}">
                            <button class="nav-link" type="button"><i data-feather="user"></i>
                                Logout</button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-xxl-9 col-lg-8">
                <button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                    Menu</button>
                <div class="dashboard-right-sidebar">
                    <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            <div class="dashboard-profile">
                                <div class="title">
                                    <h2>My Profile</h2>
                                    <span class="title-leaf">
                                        <svg class="icon-width bg-gray">
                                            <use xlink:href="{{asset('assets/svg/leaf.svg')}}#leaf"></use>
                                        </svg>
                                    </span>
                                </div>

                                <div class="profile-about dashboard-bg-box">
                                    <div class="row">
                                        <div class="col-xxl-7">
                                            <div class="dashboard-title mb-3">
                                                <h3>Profile About</h3>
                                            </div>

                                            <div class="table-responsive" id="user-profile">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Fullname :</td>
                                                            <td id="profile_name">{{ Auth::guard('web')->user()->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Birthday :</td>
                                                            <td id="profile_dob">@if(Auth::guard('web')->user()->dob) {{ date('m/d/Y', strtotime(Auth::guard('web')->user()->dob)) }} @else - @endif</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone Number :</td>
                                                            <td>
                                                                <a id="profile_phone" href="javascript:void(0)">{{ Auth::guard('web')->user()->phone }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email :</td>
                                                            <td>
                                                                <a id="profile_email" href="javascript:void(0)">{{ Auth::guard('web')->user()->email }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Address :</td>
                                                            <td id="profile_address">
                                                                @if(Auth::guard('web')->user()->addresses)
                                                                    @foreach(json_decode(Auth::guard('web')->user()->addresses) as $address)
                                                                        @if($address->main == 1)
                                                                            {{ $address->address }}
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="javascript:void(0)"><span class="m-0" id="editProfileBtn">Edit profile</span></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        
                                                        <tr>
                                                            <td>Password :</td>
                                                            <td>
                                                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#changePassword">●●●●●●
                                                                    <span id="changePasswordBtn">Change password</span></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-xxl-5">
                                            <div class="profile-image">
                                                <img src="{{asset('assets/images/inner-page/dashboard-profile.png')}}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="pills-order" role="tabpanel"
                            aria-labelledby="pills-order-tab">
                            <div class="dashboard-order">
                                <div class="title">
                                    <h2>My Orders History</h2>
                                    <span class="title-leaf title-leaf-gray">
                                        <svg class="icon-width bg-gray">
                                            <use xlink:href="{{asset('assets/svg/leaf.svg')}}#leaf"></use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="order-contain row g-sm-4 g-3">
                                    <div id="orders-container" class="load_order_feed">
                                        @if($userOrders && count($userOrders) > 0)
                                            @foreach ($userOrders as $order)
                                                @include('app.profile.order-list', [$order])
                                            @endforeach
                                            @include('app.pagination',['paginator'=>$userOrders,'paginatorClass'=>'order_feed'])
                                        @else
                                            <div class="no-order-message" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                <h3 class="text-content fw-light">You don't have any orders yet.</h3>
                                                <button onclick="location.href = '{{route('shop')}}';" class="btn theme-bg-color text-white btn-sm fw-bold mt-3">Shop now
                                                    <i class="fa-solid fa-arrow-right icon"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="pills-wishlist" role="tabpanel"
                            aria-labelledby="pills-wishlist-tab">
                            <div class="dashboard-wishlist">
                                <div class="title">
                                    <h2>My Wishlist History</h2>
                                    <span class="title-leaf title-leaf-gray">
                                        <svg class="icon-width bg-gray">
                                            <use xlink:href="{{asset('assets/svg/leaf.svg')}}#leaf"></use>
                                        </svg>
                                    </span>
                                </div>
                                <div class="row g-sm-4 g-3">
                                    @if($wishlistProducts && count($wishlistProducts) > 0)
                                        @foreach ($wishlistProducts as $wishlistProduct)
                                            @include('app.product-wishlist-item', ['product' => $wishlistProduct, 'classContainer' => 'col-xxl-3 col-lg-6 col-md-4 col-sm-6 product-box-contain wishlistItem', 'classType'=>'white'])
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
                                <!-- <div class="row g-sm-4 g-3">
                                    <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                        <div class="product-box-3 theme-bg-white h-100">
                                            <div class="product-header">
                                                <div class="product-image">
                                                    <a href="product-left-thumbnail.html">
                                                        <img src="../assets/images/cake/product/2.png"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>

                                                    <div class="product-header-top">
                                                        <button class="btn wishlist-button close_button">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-footer">
                                                <div class="product-detail">
                                                    <span class="span-name">Vegetable</span>
                                                    <a href="product-left-thumbnail.html">
                                                        <h5 class="name">Fresh Bread and Pastry Flour 200 g</h5>
                                                    </a>
                                                    <p class="text-content mt-1 mb-2 product-content">Cheesy feet
                                                        cheesy grin brie. Mascarpone cheese and wine hard cheese the
                                                        big cheese everyone loves smelly cheese macaroni cheese
                                                        croque monsieur.</p>
                                                    <h6 class="unit mt-1">250 ml</h6>
                                                    <h5 class="price">
                                                        <span class="theme-color">$08.02</span>
                                                        <del>$15.15</del>
                                                    </h5>
                                                    <div class="add-to-cart-box mt-2">
                                                        <button class="btn btn-add-cart addcart-button"
                                                            tabindex="0">Add
                                                            <span class="add-icon">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="cart_qty qty-box">
                                                            <div class="input-group">
                                                                <button type="button" class="qty-left-minus"
                                                                    data-type="minus" data-field="">
                                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                                </button>
                                                                <input class="form-control input-number qty-input"
                                                                    type="text" name="quantity" value="0">
                                                                <button type="button" class="qty-right-plus"
                                                                    data-type="plus" data-field="">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                        <div class="product-box-3 theme-bg-white h-100">
                                            <div class="product-header">
                                                <div class="product-image">
                                                    <a href="product-left-thumbnail.html">
                                                        <img src="../assets/images/cake/product/3.png"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>

                                                    <div class="product-header-top">
                                                        <button class="btn wishlist-button close_button">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-footer">
                                                <div class="product-detail">
                                                    <span class="span-name">Vegetable</span>
                                                    <a href="product-left-thumbnail.html">
                                                        <h5 class="name">Peanut Butter Bite Premium Butter Cookies
                                                            600 g</h5>
                                                    </a>
                                                    <p class="text-content mt-1 mb-2 product-content">Feta taleggio
                                                        croque monsieur swiss manchego cheesecake dolcelatte
                                                        jarlsberg. Hard cheese danish fontina boursin melted cheese
                                                        fondue.</p>
                                                    <h6 class="unit mt-1">350 G</h6>
                                                    <h5 class="price">
                                                        <span class="theme-color">$04.33</span>
                                                        <del>$10.36</del>
                                                    </h5>
                                                    <div class="add-to-cart-box mt-2">
                                                        <button class="btn btn-add-cart addcart-button"
                                                            tabindex="0">Add
                                                            <span class="add-icon">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="cart_qty qty-box">
                                                            <div class="input-group">
                                                                <button type="button" class="qty-left-minus"
                                                                    data-type="minus" data-field="">
                                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                                </button>
                                                                <input class="form-control input-number qty-input"
                                                                    type="text" name="quantity" value="0">
                                                                <button type="button" class="qty-right-plus"
                                                                    data-type="plus" data-field="">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                        <div class="product-box-3 theme-bg-white h-100">
                                            <div class="product-header">
                                                <div class="product-image">
                                                    <a href="product-left-thumbnail.html">
                                                        <img src="../assets/images/cake/product/4.png"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>

                                                    <div class="product-header-top">
                                                        <button class="btn wishlist-button close_button">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-footer">
                                                <div class="product-detail">
                                                    <span class="span-name">Snacks</span>
                                                    <a href="product-left-thumbnail.html">
                                                        <h5 class="name">SnackAmor Combo Pack of Jowar Stick and
                                                            Jowar Chips</h5>
                                                    </a>
                                                    <p class="text-content mt-1 mb-2 product-content">Lancashire
                                                        hard cheese parmesan. Danish fontina mozzarella cream cheese
                                                        smelly cheese cheese and wine cheesecake dolcelatte stilton.
                                                        Cream cheese parmesan who moved my cheese when the cheese
                                                        comes out everybody's happy cream cheese red leicester
                                                        ricotta edam.</p>
                                                    <h6 class="unit mt-1">570 G</h6>
                                                    <h5 class="price">
                                                        <span class="theme-color">$12.52</span>
                                                        <del>$13.62</del>
                                                    </h5>
                                                    <div class="add-to-cart-box mt-2">
                                                        <button class="btn btn-add-cart addcart-button"
                                                            tabindex="0">Add
                                                            <span class="add-icon">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="cart_qty qty-box">
                                                            <div class="input-group">
                                                                <button type="button" class="qty-left-minus"
                                                                    data-type="minus" data-field="">
                                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                                </button>
                                                                <input class="form-control input-number qty-input"
                                                                    type="text" name="quantity" value="0">
                                                                <button type="button" class="qty-right-plus"
                                                                    data-type="plus" data-field="">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                        <div class="product-box-3 theme-bg-white h-100">
                                            <div class="product-header">
                                                <div class="product-image">
                                                    <a href="product-left-thumbnail.html">
                                                        <img src="../assets/images/cake/product/5.png"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>

                                                    <div class="product-header-top">
                                                        <button class="btn wishlist-button close_button">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-footer">
                                                <div class="product-detail">
                                                    <span class="span-name">Snacks</span>
                                                    <a href="product-left-thumbnail.html">
                                                        <h5 class="name">Yumitos Chilli Sprinkled Potato Chips 100 g
                                                        </h5>
                                                    </a>
                                                    <p class="text-content mt-1 mb-2 product-content">Cheddar
                                                        cheddar pecorino hard cheese hard cheese cheese and biscuits
                                                        bocconcini babybel. Cow goat paneer cream cheese fromage
                                                        cottage cheese cauliflower cheese jarlsberg.</p>
                                                    <h6 class="unit mt-1">100 G</h6>
                                                    <h5 class="price">
                                                        <span class="theme-color">$10.25</span>
                                                        <del>$12.36</del>
                                                    </h5>
                                                    <div class="add-to-cart-box mt-2">
                                                        <button class="btn btn-add-cart addcart-button"
                                                            tabindex="0">Add
                                                            <span class="add-icon">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="cart_qty qty-box">
                                                            <div class="input-group">
                                                                <button type="button" class="qty-left-minus"
                                                                    data-type="minus" data-field="">
                                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                                </button>
                                                                <input class="form-control input-number qty-input"
                                                                    type="text" name="quantity" value="0">
                                                                <button type="button" class="qty-right-plus"
                                                                    data-type="plus" data-field="">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                        <div class="product-box-3 theme-bg-white h-100">
                                            <div class="product-header">
                                                <div class="product-image">
                                                    <a href="product-left-thumbnail.html">
                                                        <img src="../assets/images/cake/product/6.png"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>

                                                    <div class="product-header-top">
                                                        <button class="btn wishlist-button close_button">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-footer">
                                                <div class="product-detail">
                                                    <span class="span-name">Vegetable</span>
                                                    <a href="product-left-thumbnail.html">
                                                        <h5 class="name">Fantasy Crunchy Choco Chip Cookies</h5>
                                                    </a>
                                                    <p class="text-content mt-1 mb-2 product-content">Bavarian
                                                        bergkase smelly cheese swiss cut the cheese lancashire who
                                                        moved my cheese manchego melted cheese. Red leicester paneer
                                                        cow when the cheese comes out everybody's happy croque
                                                        monsieur goat melted cheese port-salut.</p>
                                                    <h6 class="unit mt-1">550 G</h6>
                                                    <h5 class="price">
                                                        <span class="theme-color">$14.25</span>
                                                        <del>$16.57</del>
                                                    </h5>
                                                    <div class="add-to-cart-box mt-2">
                                                        <button class="btn btn-add-cart addcart-button"
                                                            tabindex="0">Add
                                                            <span class="add-icon">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="cart_qty qty-box">
                                                            <div class="input-group">
                                                                <button type="button" class="qty-left-minus"
                                                                    data-type="minus" data-field="">
                                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                                </button>
                                                                <input class="form-control input-number qty-input"
                                                                    type="text" name="quantity" value="0">
                                                                <button type="button" class="qty-right-plus"
                                                                    data-type="plus" data-field="">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                        <div class="product-box-3 theme-bg-white h-100">
                                            <div class="product-header">
                                                <div class="product-image">
                                                    <a href="product-left-thumbnail.html">
                                                        <img src="../assets/images/cake/product/7.png"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>

                                                    <div class="product-header-top">
                                                        <button class="btn wishlist-button close_button">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-footer">
                                                <div class="product-detail">
                                                    <span class="span-name">Vegetable</span>
                                                    <a href="product-left-thumbnail.html">
                                                        <h5 class="name">Fresh Bread and Pastry Flour 200 g</h5>
                                                    </a>
                                                    <p class="text-content mt-1 mb-2 product-content">Melted cheese
                                                        babybel chalk and cheese. Port-salut port-salut cream cheese
                                                        when the cheese comes out everybody's happy cream cheese
                                                        hard cheese cream cheese red leicester.</p>
                                                    <h6 class="unit mt-1">1 Kg</h6>
                                                    <h5 class="price">
                                                        <span class="theme-color">$12.68</span>
                                                        <del>$14.69</del>
                                                    </h5>
                                                    <div class="add-to-cart-box mt-2">
                                                        <button class="btn btn-add-cart addcart-button"
                                                            tabindex="0">Add
                                                            <span class="add-icon">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="cart_qty qty-box">
                                                            <div class="input-group">
                                                                <button type="button" class="qty-left-minus"
                                                                    data-type="minus" data-field="">
                                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                                </button>
                                                                <input class="form-control input-number qty-input"
                                                                    type="text" name="quantity" value="0">
                                                                <button type="button" class="qty-right-plus"
                                                                    data-type="plus" data-field="">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                        <div class="product-box-3 theme-bg-white h-100">
                                            <div class="product-header">
                                                <div class="product-image">
                                                    <a href="product-left-thumbnail.html">
                                                        <img src="../assets/images/cake/product/2.png"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>

                                                    <div class="product-header-top">
                                                        <button class="btn wishlist-button close_button">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-footer">
                                                <div class="product-detail">
                                                    <span class="span-name">Vegetable</span>
                                                    <a href="product-left-thumbnail.html">
                                                        <h5 class="name">Fresh Bread and Pastry Flour 200 g</h5>
                                                    </a>
                                                    <p class="text-content mt-1 mb-2 product-content">Squirty cheese
                                                        cottage cheese cheese strings. Red leicester paneer danish
                                                        fontina queso lancashire when the cheese comes out
                                                        everybody's happy cottage cheese paneer.</p>
                                                    <h6 class="unit mt-1">250 ml</h6>
                                                    <h5 class="price">
                                                        <span class="theme-color">$08.02</span>
                                                        <del>$15.15</del>
                                                    </h5>
                                                    <div class="add-to-cart-box mt-2">
                                                        <button class="btn btn-add-cart addcart-button"
                                                            tabindex="0">Add
                                                            <span class="add-icon">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="cart_qty qty-box">
                                                            <div class="input-group">
                                                                <button type="button" class="qty-left-minus"
                                                                    data-type="minus" data-field="">
                                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                                </button>
                                                                <input class="form-control input-number qty-input"
                                                                    type="text" name="quantity" value="0">
                                                                <button type="button" class="qty-right-plus"
                                                                    data-type="plus" data-field="">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        

                        <div class="tab-pane fade show" id="pills-address" role="tabpanel"
                            aria-labelledby="pills-address-tab">
                            <div class="dashboard-address">
                                <div class="title title-flex">
                                    <div>
                                        <h2>My Address Book</h2>
                                        <span class="title-leaf">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="../assets/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>

                                    <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3 editAddressBtn" data-id="-1"><i data-feather="plus"
                                            class="me-2"></i> Add New Address</button>
                                </div>

                                <div class="row g-sm-4 g-3" id="addresses_container">
                                    @if(Auth::guard('web')->user()->addresses)
                                        @foreach(json_decode(Auth::guard('web')->user()->addresses) as $key => $address)
                                            @include('app.profile.addressBlock', ['key' => $key, 'address' => $address->address, 'main' => $address->main])
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- User Dashboard Section End -->

<!-- Add address modal box start -->
<div class="modal fade theme-modal" id="editAddress" tabindex="-1" aria-labelledby="editAddressModal"
        aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAddressModal">Add a new address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="editAddress-form">
                <input type="hidden" name="editAddressId" id="editAddressId" value="">
                @csrf
                <div class="modal-body">
                    <div class="form-floating mb-4 theme-form-floating">
                        <textarea class="form-control" name="address" id="address" style="height: 100px"></textarea>
                        <label for="address">Enter Address</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="saveAddressBtn" class="btn theme-bg-color btn-md text-white" >Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add address modal box end -->

<!-- Edit Profile Start -->
<div class="modal fade theme-modal" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel2"
aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="editProfile-form">
            @csrf
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-xxl-12">
                        <div class="form-floating theme-form-floating">
                            <input type="text" class="form-control" name="name" id="edit_name" value="">
                            <label for="pname">Full Name</label>
                        </div>
                    </div>

                    <div class="col-xxl-6">
                        <div class="form-floating theme-form-floating">
                            <input type="email" class="form-control" name="email" id="edit_email" value="">
                            <label for="email1">Email address</label>
                        </div>
                    </div>

                    <div class="col-xxl-6">
                        <div class="form-floating theme-form-floating">
                            <input class="form-control" type="tel" value="" name="phone" id="edit_phone">
                            <label for="mobile">Phone</label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-floating theme-form-floating">
                            <input type="text" class="form-control" name="address" id="edit_address" value="">
                            <label for="edit_address">Main Address</label>
                        </div>
                    </div>
                
                    <div class="col-md-6">
                        <div class="form-floating theme-form-floating date-box">
                            <input type="date" class="form-control" name="dob" id="edit_dob">
                            <label>Select Date</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-animation btn-md fw-bold"
                    data-bs-dismiss="modal">Close</button>
                <button type="submit" id="saveProfileBtn" class="btn theme-bg-color btn-md fw-bold text-light">Save changes</button>
            </div>
        </form>
    </div>
</div>
</div>

<div class="modal fade theme-modal" id="changePassword" tabindex="-1" aria-labelledby="passwordModal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="passwordModal">Change password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="changePassword-form">
            @csrf
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-xxl-12">
                        <div class="form-floating theme-form-floating">
                            <input type="password" class="form-control" name="current_password" required id="current_password" value="">
                            <label for="current_password">Current password</label>
                        </div>
                    </div>
                    <div class="col-xxl-12">
                        <div class="form-floating theme-form-floating">
                            <input type="password" class="form-control" name="new_password" required id="new_password" value="">
                            <label for="new_password">New password</label>
                        </div>
                    </div>
                    <div class="col-xxl-12">
                        <div class="form-floating theme-form-floating">
                            <input type="password" class="form-control" name="confirm_password" required id="confirm_password" value="">
                            <label for="confirm_password">Re-type new password</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-animation btn-md fw-bold"
                    data-bs-dismiss="modal">Close</button>
                <button type="submit" id="savePasswordBtn" class="btn theme-bg-color btn-md fw-bold text-light">Save</button>
            </div>
        </form>
    </div>
</div>
</div>
<!-- Edit Profile End -->
@push('script')
<script>
    $(document).ready(function() {
        $(document).on('click', '.order_feed a', function(e) {
            e.preventDefault();
            performAjaxOrders($(this).attr('href'));
        });

        function performAjaxOrders(urlPath) {
            // url = urlPath || $('#feed_url').val();
            url = urlPath;
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('.order_feed').html(data.products).removeClass('content_loader');
                    feather.replace();
                },
                beforeSend: function() {
                    $('.order_feed').addClass('content_loader');
                }
            });
        }

        $('#changePassword-form').submit(function(event) {
            event.preventDefault();
            btn = $('#savePasswordBtn');
            Loading.add(btn);
            var formData = new FormData(this);

            $('#changePassword-form span.error').remove();
            $.ajax({
                type: 'POST',
                url: "{{ route('changePasswordSubmit') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if(response.success == 1){
                        $('#current_password').val('');
                        $('#new_password').val('');
                        $('#confirm_password').val('');
                        
                        $('#changePassword').modal('hide');
                    }else{
                        alert('Something wrong, please try later');
                    }
                    Loading.remove(btn);
                },
                error: function(response) {
                    if(response.responseJSON && response.responseJSON.errors){
                        errors = response.responseJSON.errors
                        console.log(errors);
                        $.each( errors, function( key, value ) {
                            if($("#changePassword-form [name="+key+"]").length > 0){
                                $( "#changePassword-form [name="+key+"]" ).after( '<span class="error">'+value+'</span>' );
                            }
                        });
                    }else{
                        alert('Something wrong. pls try again');
                    }
                    Loading.remove(btn);
                }
            });
        });

        $('#editProfileBtn').on('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: "{{route('editAccount')}}",
                method: 'GET',
                success: function(response) {
                    $('#editProfile #edit_name').val(response.name);
                    $('#editProfile #edit_email').val(response.email);
                    $('#editProfile #edit_phone').val(response.phone);
                    $('#editProfile #edit_address').val(response.address);
                    $('#editProfile #edit_dob').val(response.dob);
                    // $('#view .title-name').text(response.title);
                    // $('#view .product_descirption').text(response.description);
                    // $('#view .category_title').text(response.category_title);


                    $('#editProfile').modal('show');
                },
                error: function() {
                    alert("Failed to fetch product details!");
                }
            });
        });
        $('#editProfile-form').submit(function(event) {
            event.preventDefault();
            btn = $('#saveProfileBtn');
            Loading.add(btn);
            var formData = new FormData(this);

            $('#editProfile-form span.error').remove();
            $.ajax({
                type: 'POST',
                url: "{{ route('saveAccount') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    $('#user-profile #profile_name').html(response.name);
                    $('#headerFullname').html(response.name);
                    $('#dashboard_name').html(response.name);
                    $('#user-profile #profile_dob').html(response.dob);
                    $('#user-profile #profile_phone').html(response.phone);
                    $('#user-profile #profile_email').html(response.email);
                    $('#dashboard_email').html(response.email);
                    $('#user-profile #profile_address').html(response.address);
                    
                    $('#editProfile').modal('hide');
                    Loading.remove(btn);
                },
                error: function(response) {
                    if(response.responseJSON && response.responseJSON.errors){
                        errors = response.responseJSON.errors
                        $.each( errors, function( key, value ) {
                            if($("#editProfile-form [name="+key+"]").length > 0){
                                $( "#editProfile-form [name="+key+"]" ).after( '<span class="error">'+value+'</span>' );
                            }
                        });
                    }else{
                        alert('Something wrong. pls try again');
                    }
                    Loading.remove(btn);
                }
            });
        });

        $('#editAddress-form').submit(function(event) {
            event.preventDefault();
            btn = $('#saveAddressBtn');
            Loading.add(btn);
            var formData = new FormData(this);

            $('#editAddress-form span.error').remove();
            $.ajax({
                type: 'POST',
                url: "{{ route('saveAddress') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if(response.status == 0){
                        Loading.remove(btn);
                        alert(response.message);
                        return;
                    }
                    if(response.newAddress === false){
                        $('#user_address_'+response.address_id).html(response.address);
                    }else{
                        $('#addresses_container').append(response.newAddressHtml);
                    }
                    feather.replace();
                    $('#editAddress').modal('hide');
                    Loading.remove(btn);
                },
                error: function(response) {
                    if(response.responseJSON && response.responseJSON.errors){
                        errors = response.responseJSON.errors
                        $.each( errors, function( key, value ) {
                            if($("#editAddress-form [name="+key+"]").length > 0){
                                $( "#editAddress-form [name="+key+"]" ).after( '<span class="error">'+value+'</span>' );
                            }
                        });
                    }else{
                        alert('Something wrong. pls try again');
                    }
                    Loading.remove(btn);
                }
            });
        });
        
        $( document ).on( "click", ".editAddressBtn", function(event) {
            event.preventDefault();

            var address_id = $(this).data('id');
            if(address_id == '-1'){
                $('#editAddressModal').html('Add a new address');
                $('#editAddress #editAddressId').val('-1');
                $('#editAddress #address').val('');
                $('#editAddress').modal('show');
                return;
            }
            $.ajax({
                url: "{{route('editAddress')}}?address_id="+address_id+"",
                method: 'GET',
                success: function(response) {
                    if(response.status == '1'){
                        $('#editAddressModal').html('Edit address');
                        $('#editAddress #editAddressId').val(address_id);
                        $('#editAddress #address').val(response.address);
                        $('#editAddress').modal('show');
                    }else{
                        alert(response.message);
                    }
                },
                error: function() {
                    alert("Failed to fetch address details!");
                }
            });
        });

        $( document ).on( "click", ".removeAddressBtn", function(event) {
            event.preventDefault();

            var address_id = $(this).data('id');
            $.ajax({
                url: "{{route('removeAddress')}}?address_id="+address_id+"",
                method: 'GET',
                success: function(response) {
                    if(response.status == '1'){
                        $('#addresses_container').html(response.newAddressHtml);
                        feather.replace();
                    }else{
                        alert(response.message);
                    }
                },
                error: function() {
                    alert("Failed to fetch address details!");
                }
            });
        });

        $(document).on("click", "input[type='radio'][name='user_addresses']", function(event) {
            event.preventDefault();

            var address_id = $(this).data('id');
            $.ajax({
                url: "{{ route('setMainAddress') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    address_id: address_id
                },
                success: function(response) {
                    if(response.status == '1'){
                        $("input[type='radio'][name='user_addresses']").prop('checked', false);
                        $("input[type='radio'][name='user_addresses'][data-id='" + address_id + "']").prop('checked', true);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert("Failed to set the main address!");
                }
            });
        });
    });
</script>
@endpush
@endsection