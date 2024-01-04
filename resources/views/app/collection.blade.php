@extends('app.layouts.app')
@section('content')
@push('css')
<link rel="stylesheet" href="{!! asset('css/catalog.css') !!}">
@endpush
<main>
    <input type="hidden" id="feed_url" value="{{ route('collection', ['slug'=>$collection->slug])}}">
    <div class="catalog__top">
        <div class="m-b-24 p-b-20 d-flex flex-row w-100 justify-content-center align-items-center catalog__top-links breadcrumbs">
			<span class="m-r-6"><a href="{{route('homepage')}}">{{trans('app.home')}}</a></span>
            <img class="m-r-6" src="{!! asset('assets/img/icons/circle.svg') !!}" alt="circle">
            <span>{{$collection->title}}</span>
        </div>
        <div class="m-b-24 title w-100 d-flex justify-content-center">
            <p class="m-0 p-0">{{$collection->title}}</p>
        </div>
    <div class="m-b-24 catalog__active-filters">
        <div class="wrapper">
            <div class="d-flex align-items-center justify-content-between for-wrapping-media">

                <div class='filters-button-div'>
                    <div class="filter-information">
                        <div class='filter_image m-l-14'>
                            <img src="{!! asset('assets/img/icons/filter_list.svg') !!}" alt="fil">
                        </div>
                        <!-- <div class='filter_button'>
                            <p>{{trans('app.filter')}}</p>
                        </div>
                        <div class='filters_count'>
                            <p class="m-r-14">6</p>
                        </div> -->
                    </div>
                </div>

                <ul class="d-flex align-items-center flex-wrap need-to-hide-in-responsive">
                    <!-- <li class="d-flex align-items-center m-r-8 p-t-7 p-b-7 p-l-10 p-r-10">
                        <p>Achaval Ferrer</p>
                        <img class="m-l-12" src="{!! asset('assets/img/icons/close.svg') !!}" alt="">
                    </li>
                    <li class="d-flex align-items-center m-r-8 p-t-7 p-b-7 p-l-10 p-r-10">
                        <p>Zonin</p>
                        <img class="m-l-12" src="{!! asset('assets/img/icons/close.svg') !!}" alt="">
                    </li>
                    <li class="d-flex align-items-center m-r-8 p-t-7 p-b-7 p-l-10 p-r-10">
                        <p>Dedicado</p>
                        <img class="m-l-12" src="{!! asset('assets/img/icons/close.svg') !!}" alt="">
                    </li> -->
                    <li class="d-flex align-items-center">
                        <p>{{trans('app.finded')}} <span class="grid_item_count">{{$totalCount}}</span> {{trans('app.finded_items')}}</p>
                    </li>
                </ul>
                <select class="form-select w-auto border-0" id="sort" name="sort" aria-label="Default select example">
                    <option selected value="1">{{trans('app.sort_desc')}}</option>
                    <option value="2">{{trans('app.sort_asc')}}</option>
                    <option value="3">{{trans('app.sort_discount')}}</option>
                    <option value="4">{{trans('app.sort_new')}}</option>
                </select>
                <div class="filter-results-quantity">
                    <p>{{trans('app.finded')}} <span class="grid_item_count">{{$totalCount}}</span> {{trans('app.finded_items')}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="catalog__content w-100 wrapper align-items-start">
        <aside class="filter need-to-hide-in-responsive">
            <div class="accordion">
            @foreach($attributes as $attribute)
                <div class="accordion-section m-b-20 relative p-b-20">
                    <h3 class=" cursor-pointer accordion-header filter-title d-flex align-items-center justify-content-between w-100">
                        <p class="p-0 m-0 text-uppercase">{{$attribute['name']}}</p>
                        <img src="{!! asset('assets/img/icons/filterArrow.svg') !!}" alt="">
                    </h3>
                    <div class="accordion-content d-flex flex-column"  id="color">
                        @foreach($attribute['values'] as $value)
                            <div class="m-b-6 d-flex align-items-center justify-content-between">
                                <div class="checkbox">
                                    <input class="custom-checkbox" type="checkbox" id="{{$attribute['name']}}{{$value['id']}}" onclick="shop('{{$attribute['name']}}',{{$value['id']}})" name="checkbox">
                                    <label for="{{$attribute['name']}}{{$value['id']}}">{{$value['value']}}</label>
                                </div>
                                <p class="p-0 m-0 count">{{$value['count']}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

                <div class="accordion-section relative p-b-20">
                    <h3 class=" cursor-r accordion-header filter-title d-flex align-items-center justify-content-between w-100 open-on-load">
                        <p class="p-0 pointem-0">Գին</p>
                        <img src="{!! asset('assets/img/icons/filterArrow.svg') !!}" alt="">
                    </h3>
                    <div class="accordion-content d-flex flex-column">
                        <div class="row align-items-center price">
                            <div class="col-6 price d-flex flex-column">
                                <label for="from">From</label>
                                <input class="p-r-16 p-l-16 p-t-11 p-b-13 removed-nav" type="number" id="price_from" placeholder="0 ֏"
                                       value="">
                            </div>
                            <div class="col-6 price d-flex flex-column">
                                <label for="to">To</label>
                                <input class="p-r-16 p-l-16 p-t-11 p-b-13 removed-nav" type="number" id="price_to" placeholder="100000 ֏"
                                       value="">
                            </div>
                        </div>
                        <!-- <div class="m-t-15 d-flex align-items-center justify-content-between">
                            <div class="checkbox">
                                <input class="custom-checkbox" type="checkbox" id="checkbox13" name="checkbox">
                                <label for="checkbox13">Մինչև 7,000 ֏</label>
                            </div>
                            <p class="p-0 m-0 count">30</p>
                        </div>
                        <div class="m-t-15 d-flex align-items-center justify-content-between">
                            <div class="checkbox">
                                <input class="custom-checkbox" type="checkbox" id="checkbox13" name="checkbox">
                                <label for="checkbox13">Սկսած 35,000 ֏</label>
                            </div>
                            <p class="p-0 m-0 count">30</p>
                        </div> -->
                    </div>
                </div>
            </div>
        </aside>

        <div class="d-flex flex-column">
			@if($feed)
			<div id="products" class="w-100 row flex-wrap align-items-stretch load_feed">
                @foreach ($feed as $product)
                    @include('app.product-list-item', [$product])
                @endforeach
                @include('app.pagination',['paginator'=>$feed,'paginatorClass'=>'product_feed'])
			</div>
            @endif
        </div>
    </div>

    <!-- <div style="margin-top: 40px;" class="wrapper filters__list w-100 d-flex align-items-center flex-wrap p-b-24">
        <div class="d-flex align-items-center p-l-24 p-r-24 p-t-8 p-b-8 justify-content-center m-r-16 m-b-16 cursor-pointer">
            <p class="text-nowrap">Գինի մինչև 3,000 ֏ </p>
        </div>
        <div class="d-flex align-items-center p-l-24 p-r-24 p-t-8 p-b-8 justify-content-center m-r-16 m-b-16 cursor-pointer">
            <p class="text-nowrap">Գինի մինչև 5,000 ֏ </p>
        </div>
        <div class="d-flex align-items-center p-l-24 p-r-24 p-t-8 p-b-8 justify-content-center m-r-16 m-b-16 cursor-pointer">
            <p class="text-nowrap">Ոչ ալկոհոլային</p>
        </div>
        <div class="d-flex align-items-center p-l-24 p-r-24 p-t-8 p-b-8 justify-content-center m-r-16 m-b-16 cursor-pointer">
            <p class="text-nowrap">Ձկան հետ</p>
        </div>
        <div class="d-flex align-items-center p-l-24 p-r-24 p-t-8 p-b-8 justify-content-center m-r-16 m-b-16 cursor-pointer">
            <p class="text-nowrap">Հորթի մսի հետ</p>
        </div>
        <div class="d-flex align-items-center p-l-24 p-r-24 p-t-8 p-b-8 justify-content-center m-r-16 m-b-16 cursor-pointer">
            <p class="text-nowrap">Իտալիա</p>
        </div>
        <div class="d-flex align-items-center p-l-24 p-r-24 p-t-8 p-b-8 justify-content-center m-r-16 m-b-16 cursor-pointer">
            <p class="text-nowrap">Արգենտինա</p>
        </div>
        <div class="d-flex align-items-center p-l-24 p-r-24 p-t-8 p-b-8 justify-content-center m-r-16 m-b-16 cursor-pointer">
            <p class="text-nowrap">Պորտուգալիա</p>
        </div>
        <div class="d-flex align-items-center p-l-24 p-r-24 p-t-8 p-b-8 justify-content-center m-r-16 m-b-16 cursor-pointer">
            <p class="text-nowrap">Օղի</p>
        </div>
        <div class="d-flex align-items-center p-l-24 p-r-24 p-t-8 p-b-8 justify-content-center m-r-16 m-b-16 cursor-pointer">
            <p class="text-nowrap">Կարմիր գինի</p>
        </div>
        <div class="d-flex align-items-center p-l-24 p-r-24 p-t-8 p-b-8 justify-content-center m-r-16 m-b-16 cursor-pointer">
            <p class="text-nowrap">Փրփրուն</p>
        </div>
    </div> -->
    <!-- <div class="d-flex flex-column w-100 view__history">
        <div class="title text-center p-t-24 m-b-40">
            <p class="m-0 p-0">Դիտումների պատմություն</p>
        </div>
        <div style="view_container max-width: 1490px; width: 100%;" class="mx-auto p-l-25 p-r-25 position-relative m-b-120">
            <div class="w-100 view__history-slider overflow-hidden">
                <a href="#!" class="text-decoration-none slide p-10">
                    <div class="p-20 d-flex align-items-center">
                        <div class="d-flex align-items-center flex-column">
                            <img src="{!! asset('assets/img/viewHistory1.png') !!}" alt="">
                        </div>
                        <div class="d-flex align-items-start flex-column m-l-20">
                            <div class="title m-b-8"><p class="p-0 m-0">Gin Katun, Destilados y Licores Meridanos S.A. de C.V, 700 մլ</p></div>
                            <div class="new__price"><p class="m-0 p-0">23,840 ֏</p></div>
                            <div class="old__price"><p class="m-0 p-0">29,800 ֏</p></div>
                        </div>
                    </div>
                </a>
                <a href="#!" class="text-decoration-none slide p-10">
                    <div class="p-20 d-flex align-items-center">
                        <div class="d-flex align-items-center flex-column">
                            <img src="{!! asset('assets/img/viewHistory1.png') !!}" alt="">
                        </div>
                        <div class="d-flex align-items-start flex-column m-l-20">
                            <div class="title m-b-8"><p class="p-0 m-0">Gin Katun, Destilados y Licores Meridanos S.A. de C.V, 700 մլ</p></div>
                            <div class="new__price"><p class="m-0 p-0">23,840 ֏</p></div>
                            <div class="old__price"><p class="m-0 p-0">29,800 ֏</p></div>
                        </div>
                    </div>
                </a>
                <a href="#!" class="text-decoration-none slide p-10">
                    <div class="p-20 d-flex align-items-center">
                        <div class="d-flex align-items-center flex-column">
                            <img src="{!! asset('assets/img/viewHistory1.png') !!}" alt="">
                        </div>
                        <div class="d-flex align-items-start flex-column m-l-20">
                            <div class="title m-b-8"><p class="p-0 m-0">Gin Katun, Destilados y Licores Meridanos S.A. de C.V, 700 մլ</p></div>
                            <div class="new__price"><p class="m-0 p-0">23,840 ֏</p></div>
                            <div class="old__price"><p class="m-0 p-0">29,800 ֏</p></div>
                        </div>
                    </div>
                </a>
                <a href="#!" class="text-decoration-none slide p-10">
                    <div class="p-20 d-flex align-items-center">
                        <div class="d-flex align-items-center flex-column">
                            <img src="{!! asset('assets/img/viewHistory1.png') !!}" alt="">
                        </div>
                        <div class="d-flex align-items-start flex-column m-l-20">
                            <div class="title m-b-8"><p class="p-0 m-0">Gin Katun, Destilados y Licores Meridanos S.A. de C.V, 700 մլ</p></div>
                            <div class="new__price"><p class="m-0 p-0">23,840 ֏</p></div>
                            <div class="old__price"><p class="m-0 p-0">29,800 ֏</p></div>
                        </div>
                    </div>
                </a>
                <a href="#!" class="text-decoration-none slide p-10">
                    <div class="p-20 d-flex align-items-center">
                        <div class="d-flex align-items-center flex-column">
                            <img src="{!! asset('assets/img/viewHistory1.png') !!}" alt="">
                        </div>
                        <div class="d-flex align-items-start flex-column m-l-20">
                            <div class="title m-b-8"><p class="p-0 m-0">Gin Katun, Destilados y Licores Meridanos S.A. de C.V, 700 մլ</p></div>
                            <div class="new__price"><p class="m-0 p-0">23,840 ֏</p></div>
                            <div class="old__price"><p class="m-0 p-0">29,800 ֏</p></div>
                        </div>
                    </div>
                </a>
                <a href="#!" class="text-decoration-none slide p-10">
                    <div class="p-20 d-flex align-items-center">
                        <div class="d-flex align-items-center flex-column">
                            <img src="{!! asset('assets/img/viewHistory1.png') !!}" alt="">
                        </div>
                        <div class="d-flex align-items-start flex-column m-l-20">
                            <div class="title m-b-8"><p class="p-0 m-0">Gin Katun, Destilados y Licores Meridanos S.A. de C.V, 700 մլ</p></div>
                            <div class="new__price"><p class="m-0 p-0">23,840 ֏</p></div>
                            <div class="old__price"><p class="m-0 p-0">29,800 ֏</p></div>
                        </div>
                    </div>
                </a>
                <a href="#!" class="text-decoration-none slide p-10">
                    <div class="p-20 d-flex align-items-center">
                        <div class="d-flex align-items-center flex-column">
                            <img src="{!! asset('assets/img/viewHistory1.png') !!}" alt="">
                        </div>
                        <div class="d-flex align-items-start flex-column m-l-20">
                            <div class="title m-b-8"><p class="p-0 m-0">Gin Katun, Destilados y Licores Meridanos S.A. de C.V, 700 մլ</p></div>
                            <div class="new__price"><p class="m-0 p-0">23,840 ֏</p></div>
                            <div class="old__price"><p class="m-0 p-0">29,800 ֏</p></div>
                        </div>
                    </div>
                </a>
                <a href="#!" class="text-decoration-none slide p-10">
                    <div class="p-20 d-flex align-items-center">
                        <div class="d-flex align-items-center flex-column">
                            <img src="{!! asset('assets/img/viewHistory1.png') !!}" alt="">
                        </div>
                        <div class="d-flex align-items-start flex-column m-l-20">
                            <div class="title m-b-8"><p class="p-0 m-0">Gin Katun, Destilados y Licores Meridanos S.A. de C.V, 700 մլ</p></div>
                            <div class="new__price"><p class="m-0 p-0">23,840 ֏</p></div>
                            <div class="old__price"><p class="m-0 p-0">29,800 ֏</p></div>
                        </div>
                    </div>
                </a>
                <a href="#!" class="text-decoration-none slide p-10">
                    <div class="p-20 d-flex align-items-center">
                        <div class="d-flex align-items-center flex-column">
                            <img src="{!! asset('assets/img/viewHistory1.png') !!}" alt="">
                        </div>
                        <div class="d-flex align-items-start flex-column m-l-20">
                            <div class="title m-b-8"><p class="p-0 m-0">Gin Katun, Destilados y Licores Meridanos S.A. de C.V, 700 մլ</p></div>
                            <div class="new__price"><p class="m-0 p-0">23,840 ֏</p></div>
                            <div class="old__price"><p class="m-0 p-0">29,800 ֏</p></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div> -->
</main>
<script>
    let ids = [];
    function shop(type,id){
       
        if(!(ids.some(el => el.id == id))){
            ids.push({id:+id,type})
        }
        else{
            ids = ids.filter(el => el.id != id)
        }

        const data = {
            type,
            filterId:ids
        }
        $.ajax({
            url:"{{ route('collection', ['slug'=>$collection->slug]) }}",
            type:'GET',
            dataType:'json',
            data,
            success: function(data) {
                $('html, body').animate({
                    scrollTop: $('.load_feed').offset().top - 100
                }, 500, function(){
                });
                $('.load_feed').html(data.products).removeClass('content_loader');
                $('.grid_item_count').html(data.totalCount);


            },
            beforeSend: function() {
                $('.load_feed').addClass('content_loader');
            },
            error: function() {
                // toastr['error'](errorThrown, 'Error');
                // Loading.remove($('#saveItemBtn'));
            }
        })
    }
</script>


@endsection


