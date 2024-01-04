@extends('app.layouts.app')
@section('content')
@push('css')
<link rel="stylesheet" href="{!! asset('css/about_us.css') !!}">
@endpush
<main>
        <div class="allWrapper m-t-80 mx-auto">
            <div class="main_image_wrapper m-b-56 d-flex justify-content-center align-items-center">
                <img class="img-fluid" src="{{asset('assets/img/logo_english.png')}}" alt="">
            </div>

            <div>
                <div class="title text-center m-b-32">
                    {{$article->title}}
                </div>

                <div class="about_as_text text-center">
                   {!!$article->body!!}
                </div>

                <div class="m-t-80 cards">
                    <div class="cards__title m-b-32">{{trans('app.about_us_sub_title')}}</div>
                    <div class="card-container">
                        <div class="line"></div>
                        <div style="background-image: url('{{asset('assets/img/icons/aboutus1.svg')}}')" class="card position-relative p-24 border-none">

                            <div class="card__line"></div>
                            <div class="card__title m-b-16 d-flex align-items-center"><span>{{trans('app.about_us_section_year_1')}}</span>
                                <div class="circle m-r-8 m-l-8"></div>
                                <span>{{trans('app.about_us_section_title_1')}}</span></div>
                            <div class="card__text"><p>{{trans('app.about_us_section_text_1')}}</p></div>
                        </div>
                        <div style="background-image: url('{{asset('assets/img/icons/aboutus2.svg')}}')" class="card p-24 border-none">
                            <div class="card__title m-b-16 d-flex align-items-center"><span>{{trans('app.about_us_section_year_2')}}</span>
                                <div class="circle m-r-8 m-l-8"></div>
                                <span>{{trans('app.about_us_section_title_2')}}</span></div>
                            <div class="card__text"><p>{{trans('app.about_us_section_text_2')}}</p></div>
                        </div>
                        <div style="background-image: url('{{asset('assets/img/icons/aboutus3.svg')}}')" class="card p-24 border-none">
                            <div class="card__title m-b-16 d-flex align-items-center"><span>{{trans('app.about_us_section_year_3')}}</span>
                                <div class="circle m-r-8 m-l-8"></div>
                                <span>{{trans('app.about_us_section_title_3')}}</span></div>
                            <div class="card__text"><p>{{trans('app.about_us_section_text_3')}}</p></div>
                        </div>
                        <div style="background-image: url('{{asset('assets/img/icons/aboutus4.svg')}}')" class="card p-24 border-none">
                            <div class="card__title m-b-16 d-flex align-items-center"><span>{{trans('app.about_us_section_year_4')}}</span>
                                <div class="circle m-r-8 m-l-8"></div>
                                <span>{{trans('app.about_us_section_title_4')}}</span></div>
                            <div class="card__text"><p>{{trans('app.about_us_section_text_4')}}</p></div>
                        </div>
                    </div>
                </div>

                <div class="title text-center m-t-80 m-b-32">{{trans('app.our_team')}}</div>
                <img style="border-radius: 16px;" class="img-fluid" src="{{asset('assets/img/our_team.png')}}" alt="">
            </div>
        </div>
    </main>
@endsection