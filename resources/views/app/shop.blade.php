@extends('app.layouts.app')
@section('content')
<?php /*
@if($nestedCollections && count($nestedCollections) > 0)
<!-- Category Section Start -->
<section class="wow fadeInUp">
    
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="slider-7_1 no-space shop-box no-arrow">
                    @foreach($nestedCollections as $topCategory)
                    <div>
                        <div class="shop-category-box">
                            <a href="{{ route('shop', ['slug'=>$topCategory->slug])}}">
                                @if($topCategory->image)
                                <div class="shop-category-image">
                                    <img src="{{asset('content/'.$topCategory->image)}}" class="blur-up lazyload" alt="">
                                </div>
                                @endif
                                <div class="category-box-name">
                                    <h6>{{$topCategory->title}}</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Category Section End -->
@endif
*/ ?>
<!-- Shop Section Start -->
<section class="section-b-space shop-section">
    <input type="hidden" id="feed_url" value="{{route('shop', ['slug'=>$collection ? $collection->slug : false])}}">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-custome-3 wow fadeInUp">
                <div class="left-box">
                    <div class="shop-left-sidebar">
                        <div class="back-button">
                            <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                        </div>

                        <!-- <div class="filter-category">
                            <div class="filter-title">
                                <h2>Filters</h2>
                                <a href="javascript:void(0)">Clear All</a>
                            </div>
                            <ul>
                                <li>
                                    <a href="javascript:void(0)">Vegetable</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Fruit</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Fresh</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Milk</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Meat</a>
                                </li>
                            </ul>
                        </div> -->

                        <div class="accordion custome-accordion" id="accordionExample">
                            @if($nestedCollections && count($nestedCollections) > 0)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        <span>Categories</span>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <!-- <div class="form-floating theme-form-floating-2 search-box">
                                            <input type="search" class="form-control" id="search"
                                                placeholder="Search ..">
                                            <label for="search">Search</label>
                                        </div> -->

                                        <ul class="category-list custom-padding custom-height">
                                            @foreach($nestedCollections as $topCategory)
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input data-level="top" class="checkbox_animated category-checkbox" @if(in_array($topCategory->id,$selectedCollection)) checked='checked' @endif type="checkbox" id="{{$topCategory->id}}">
                                                    <label class="form-check-label" for="{{$topCategory->id}}">
                                                        <span class="name">{{$topCategory->title}}</span>
                                                        <span class="number">({{$topCategory->total_product_count}})</span>
                                                    </label>
                                                </div>
                                                @if($topCategory->children && count($topCategory->children) > 0)
                                                    <ul class="cat-lvl2" data-category="{{$topCategory->id}}" @if(!in_array($topCategory->id,$selectedCollection)) style="display: none;" @endif >
                                                        @foreach($topCategory->children as $subCategory)
                                                        <li>
                                                            <div class="form-check ps-0 m-0 category-list-box">
                                                                <input data-level="sub" data-parent="{{ $topCategory->id }}" class="checkbox_animated category-checkbox" @if(in_array($subCategory->id,$selectedCollection)) checked='checked' @endif type="checkbox" id="{{$subCategory->id}}">
                                                                <label class="form-check-label" for="{{$subCategory->id}}">
                                                                    <span class="name">{{$subCategory->title}}</span>
                                                                    <span class="number">({{$subCategory->total_product_count}})</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                            @if(isset($subCategory->children) && count($subCategory->children) > 0)
                                                                <ul class="cat-lvl3" data-category="{{$subCategory->id}}" @if(!in_array($subCategory->id,$selectedCollection)) style="display: none;" @endif>
                                                                    @foreach($subCategory->children as $children)
                                                                    <li>
                                                                        <div class="form-check ps-0 m-0 category-list-box">
                                                                            <input data-level="child" data-parent="{{ $subCategory->id }}" data-grandparent="{{ $topCategory->id }}" class="checkbox_animated category-checkbox" type="checkbox" @if(in_array($children->id,$selectedCollection)) checked='checked' @endif id="{{$children->id}}">
                                                                            <label class="form-check-label" for="{{$children->id}}">
                                                                                <span class="name">{{$children->title}}</span>
                                                                                <span class="number">({{$children->total_product_count}})</span>
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree">
                                        <span>Price</span>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse show"
                                    aria-labelledby="panelsStayOpen-headingThree">
                                    <div class="accordion-body">
                                        <div class="range-slider">
                                            <input type="text" id="price-slider" class="js-range-slider" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        <span>Discount</span>
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse show"
                                    aria-labelledby="panelsStayOpen-headingFour">
                                    <div class="accordion-body">
                                        <ul class="category-list custom-padding">
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <span class="name">upto 5%</span>
                                                        <span class="number">(06)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault1">
                                                    <label class="form-check-label" for="flexCheckDefault1">
                                                        <span class="name">5% - 10%</span>
                                                        <span class="number">(08)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault2">
                                                    <label class="form-check-label" for="flexCheckDefault2">
                                                        <span class="name">10% - 15%</span>
                                                        <span class="number">(10)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault3">
                                                    <label class="form-check-label" for="flexCheckDefault3">
                                                        <span class="name">15% - 25%</span>
                                                        <span class="number">(14)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault4">
                                                    <label class="form-check-label" for="flexCheckDefault4">
                                                        <span class="name">More than 25%</span>
                                                        <span class="number">(13)</span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">
                                        <span>Pack Size</span>
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse show"
                                    aria-labelledby="panelsStayOpen-headingFive">
                                    <div class="accordion-body">
                                        <ul class="category-list custom-padding custom-height">
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault5">
                                                    <label class="form-check-label" for="flexCheckDefault5">
                                                        <span class="name">400 to 500 g</span>
                                                        <span class="number">(05)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault6">
                                                    <label class="form-check-label" for="flexCheckDefault6">
                                                        <span class="name">500 to 700 g</span>
                                                        <span class="number">(02)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault7">
                                                    <label class="form-check-label" for="flexCheckDefault7">
                                                        <span class="name">700 to 1 kg</span>
                                                        <span class="number">(04)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault8">
                                                    <label class="form-check-label" for="flexCheckDefault8">
                                                        <span class="name">120 - 150 g each Vacuum 2 pcs</span>
                                                        <span class="number">(06)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault9">
                                                    <label class="form-check-label" for="flexCheckDefault9">
                                                        <span class="name">1 pc</span>
                                                        <span class="number">(09)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault10">
                                                    <label class="form-check-label" for="flexCheckDefault10">
                                                        <span class="name">1 to 1.2 kg</span>
                                                        <span class="number">(06)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault11">
                                                    <label class="form-check-label" for="flexCheckDefault11">
                                                        <span class="name">2 x 24 pcs Multipack</span>
                                                        <span class="number">(03)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault12">
                                                    <label class="form-check-label" for="flexCheckDefault12">
                                                        <span class="name">2x6 pcs Multipack</span>
                                                        <span class="number">(04)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault13">
                                                    <label class="form-check-label" for="flexCheckDefault13">
                                                        <span class="name">4x6 pcs Multipack</span>
                                                        <span class="number">(05)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault14">
                                                    <label class="form-check-label" for="flexCheckDefault14">
                                                        <span class="name">5x6 pcs Multipack</span>
                                                        <span class="number">(09)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault15">
                                                    <label class="form-check-label" for="flexCheckDefault15">
                                                        <span class="name">Combo 2 Items</span>
                                                        <span class="number">(10)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault16">
                                                    <label class="form-check-label" for="flexCheckDefault16">
                                                        <span class="name">Combo 3 Items</span>
                                                        <span class="number">(14)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault17">
                                                    <label class="form-check-label" for="flexCheckDefault17">
                                                        <span class="name">2 pcs</span>
                                                        <span class="number">(19)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault18">
                                                    <label class="form-check-label" for="flexCheckDefault18">
                                                        <span class="name">3 pcs</span>
                                                        <span class="number">(14)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault19">
                                                    <label class="form-check-label" for="flexCheckDefault19">
                                                        <span class="name">2 pcs Vacuum (140 g to 180 g each
                                                            )</span>
                                                        <span class="number">(13)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault20">
                                                    <label class="form-check-label" for="flexCheckDefault20">
                                                        <span class="name">4 pcs</span>
                                                        <span class="number">(18)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault21">
                                                    <label class="form-check-label" for="flexCheckDefault21">
                                                        <span class="name">4 pcs Vacuum (140 g to 180 g each
                                                            )</span>
                                                        <span class="number">(07)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault22">
                                                    <label class="form-check-label" for="flexCheckDefault22">
                                                        <span class="name">6 pcs</span>
                                                        <span class="number">(09)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault23">
                                                    <label class="form-check-label" for="flexCheckDefault23">
                                                        <span class="name">6 pcs carton</span>
                                                        <span class="number">(11)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault24">
                                                    <label class="form-check-label" for="flexCheckDefault24">
                                                        <span class="name">6 pcs Pouch</span>
                                                        <span class="number">(16)</span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-custome-9 wow fadeInUp">
                <div class="show-button">
                    <div class="filter-button-group mt-0">
                        <div class="filter-button d-inline-block d-lg-none">
                            <a><i class="fa-solid fa-filter"></i> Filter Menu</a>
                        </div>
                    </div>

                    <div class="top-filter-menu">
                        <div class="category-dropdown">
                            <h5 class="text-content" style="margin-right: 10px;">Total count : <span style="font-weight: bold;" id="totalCount">{{$totalCount}}</span></h5>
                            <h5 class="text-content">Sort By :</h5>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown">
                                    <span>Most Popular</span> <i class="fa-solid fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu" id="sort" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item" id="pop" href="javascript:void(0)">Popularity</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="low" href="javascript:void(0)">Low - High
                                            Price</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="high" href="javascript:void(0)">High - Low
                                            Price</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="aToz" href="javascript:void(0)">A - Z Order</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="zToa" href="javascript:void(0)">Z - A Order</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="off" href="javascript:void(0)">% Off - Hight To
                                            Low</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="grid-option d-none d-md-block">
                            <ul>
                                <li class="three-grid" id="three-grid">
                                    <a href="javascript:void(0)">
                                        <img src="{!! asset('assets/svg/grid-3.svg') !!}" class="blur-up lazyload" alt="">
                                    </a>
                                </li>
                                <li class="grid-btn d-xxl-inline-block d-none active" id="forth-grid">
                                    <a href="javascript:void(0)">
                                        <img src="{!! asset('assets/svg/grid-4.svg') !!}"
                                            class="blur-up lazyload d-lg-inline-block d-none" alt="">
                                        <img src="{!! asset('assets/svg/grid.svg') !!}"
                                            class="blur-up lazyload img-fluid d-lg-none d-inline-block" alt="">
                                    </a>
                                </li>
                                <li class="list-btn" id="list-grid">
                                    <a href="javascript:void(0)">
                                        <img src="{!! asset('assets/svg/list.svg') !!}" class="blur-up lazyload" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
        
                @if($feed)
                <div id="products" class="load_feed">
                    <div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                        @foreach ($feed as $product)
                            @include('app.product-list-item', [$product])
                        @endforeach
                    </div>
                    @include('app.pagination',['paginator'=>$feed,'paginatorClass'=>'product_feed'])
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->
@push('script')
<script src="{!! asset('assets/js/filter-sidebar.js') !!}"></script>
<script src="{!! asset('assets/js/ion.rangeSlider.min.js') !!}"></script>
<script>
var delay = (function() {
    var timer = 0;
    return function(callback, ms) {
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

$('#price-slider').on('input', function() {
    delay(function() {
        updateProducts(false);
    }, 500); //1000
});

$(document).on('click', '.product_feed a', function(e) {
    e.preventDefault();
    updateProducts($(this).attr('href'));
});
var sorted = "pop";
$(document).ready(function() {
    $('#sort .dropdown-item').on('click', function() {
        sorted = $(this).attr('id');
        updateProducts();
    });
});

function updateProducts(urlPath) {
	url = urlPath || $('#feed_url').val();

    girdViewType = $('.grid-option ul li.active').attr('id');

    var checkboxes = document.querySelectorAll('.checkbox_animated:checked');
    var selectedCats = new Set();

    //OLD not bad working version :)
    // checkboxes.forEach(function(checkbox) {
    //     let level = checkbox.getAttribute('data-level');

    //     if (level === 'child') {
    //         let parentSubCategoryId = checkbox.getAttribute('data-parent');
    //         let parentSubCategoryCheckbox = document.getElementById(parentSubCategoryId);

    //         if (parentSubCategoryCheckbox && parentSubCategoryCheckbox.checked) {
    //             selectedCats.add(checkbox.id);

    //             if (selectedCats.has(parentSubCategoryId)) {
    //                 selectedCats.delete(parentSubCategoryId);
    //             }
    //         }
    //     }
    //     else if (level === 'sub') {
    //         let childrenCheckboxes = checkbox.closest('li').querySelectorAll('.cat-lvl3 .checkbox_animated:checked');

    //         if (!childrenCheckboxes.length) {
    //             selectedCats.add(checkbox.id);
    //         }
    //     }
    //     else if (level === 'top') {
    //         let descendentCheckboxes = checkbox.closest('li').querySelectorAll('.cat-lvl2 .checkbox_animated:checked, .cat-lvl3 .checkbox_animated:checked');

    //         if (!descendentCheckboxes.length) {
    //             selectedCats.add(checkbox.id);
    //         } else {
    //             selectedCats.delete(checkbox.id);
    //         }
    //     }
    // });
    
    checkboxes.forEach(function(checkbox) {
        let level = checkbox.getAttribute('data-level');

        if (level === 'child') {
            let parentSubCategoryId = checkbox.getAttribute('data-parent');
            let parentSubCategoryCheckbox = document.getElementById(parentSubCategoryId);

            if (parentSubCategoryCheckbox && parentSubCategoryCheckbox.checked) {
                let grandParentTopCategoryId = parentSubCategoryCheckbox.getAttribute('data-parent');
                let grandParentTopCategoryCheckbox = document.getElementById(grandParentTopCategoryId);

                if (grandParentTopCategoryCheckbox && grandParentTopCategoryCheckbox.checked) {
                    selectedCats.add(checkbox.id);
                    selectedCats.delete(parentSubCategoryId);
                }
            }
        }
        else if (level === 'sub') {
            let childrenCheckboxes = checkbox.closest('li').querySelectorAll('.cat-lvl3 .checkbox_animated:checked');

            let parentTopCategoryId = checkbox.getAttribute('data-parent');
            let parentTopCategoryCheckbox = document.getElementById(parentTopCategoryId);

            if (!childrenCheckboxes.length) {
                if (parentTopCategoryCheckbox && parentTopCategoryCheckbox.checked) {
                    selectedCats.add(checkbox.id);
                }
            }
        }
        else if (level === 'top') {
            let descendentCheckboxes = checkbox.closest('li').querySelectorAll('.cat-lvl2 .checkbox_animated:checked, .cat-lvl3 .checkbox_animated:checked');

            if (!descendentCheckboxes.length) {
                selectedCats.add(checkbox.id);
            } else {
                selectedCats.delete(checkbox.id);
            }
        }
    });
    var selectedIds = [...selectedCats];

    var priceRange = $('#price-slider').val();

    $.ajax({
        url: url,
        type: 'GET',
        data: { 
            categories: selectedIds,
            sort: sorted,
            girdViewType: girdViewType,
            priceRange: priceRange,
        },
        success: function(data) {
			$('#totalCount').html(data.totalCount);
            $('.load_feed').html(data.products).removeClass('content_loader');

            feather.replace();
        },
        beforeSend: function() {
            $('.load_feed').addClass('content_loader');
        }
    });
}
document.addEventListener('DOMContentLoaded', function() {
    var categoryCheckboxes = document.querySelectorAll('.category-checkbox');

    categoryCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var categoryId = this.id;
            var subCategories = document.querySelectorAll('.cat-lvl2');
            var subSubCategories = document.querySelectorAll('.cat-lvl3');

            if (this.checked) {
                // If category checkbox is checked, show its subcategories
                var subCategory = document.querySelector('.cat-lvl2[data-category="' + categoryId + '"]');
                if (subCategory) {
                    subCategory.style.display = 'block';
                }

                var subSubCategory = document.querySelector('.cat-lvl3[data-category="' + categoryId + '"]');
                if (subSubCategory) {
                    subSubCategory.style.display = 'block';
                }
            } else {
                // If category checkbox is unchecked, hide its subcategories and sub-subcategories
                var subCategory = document.querySelector('.cat-lvl2[data-category="' + categoryId + '"]');
                if (subCategory) {
                    subCategory.style.display = 'none';
                }

                var subSubCategory = document.querySelector('.cat-lvl3[data-category="' + categoryId + '"]');
                if (subSubCategory) {
                    subSubCategory.style.display = 'none';
                }
            }
            updateProducts();
        });
    });
});
</script>
@endpush
@endsection


