@extends('app.layouts.app')
@section('content')
<!-- Blog Details Section Start -->
<section class="blog-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">
            @if($sidebarExist)
                @include('app.blocks.sidebar')
            @endif
            <div class="col-xxl-9 col-xl-8 col-lg-7 ratio_50">
                <div class="blog-detail-image rounded-3 mb-4">
                    <img src="{{asset('images/blogSingleItem/'.$blog->img)}}" class="bg-img blur-up lazyload" alt="{{$blog->title}}">
                    <div class="blog-image-contain">
                        <h2>{{$blog->title}}</h2>
                        @if(isset($blog->published_at))
                        <ul class="contain-comment-list">
                            <li>
                                <div class="user-list">
                                    <i data-feather="calendar"></i>
                                    <span>{{ date('d M, Y', strtotime($blog->published_at)) }}</span>
                                </div>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>

                <div class="blog-detail-contain">
                    <p>{!!$blog->body!!}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Section End -->
@endsection