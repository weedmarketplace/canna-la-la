@extends('app.layouts.app')
@section('content')
<!-- Blog Section Start -->
<section class="blog-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-4">
            <div class="col-xxl-9 col-xl-8 col-lg-7 order-lg-2">
                @if($blogItems && count($blogItems) > 0)
                <div class="row g-4">
                        @foreach($blogItems as $blog)
                            <div class="col-12">
                                <div class="blog-box blog-list wow fadeInUp">
                                    <div class="blog-image">
                                        <img src="{{asset('images/blogItem/'.$blog->img)}}" class="blur-up lazyload" alt="{{$blog->title}}">
                                    </div>

                                    <div class="blog-contain blog-contain-2">
                                        @if(isset($blog->published_at))
                                        <div class="blog-label">
                                            <span class="time"><i data-feather="clock"></i> <span>{{ date('d M, Y', strtotime($blog->published_at)) }}</span></span>
                                        </div>
                                        @endif
                                        <a href="{{ route('blogItem', ['slug'=>$blog->slug])}}">
                                            <h3>{{$blog->title}}</h3>
                                        </a>
                                        <p>{{$blog->description}}</p>
                                        <button onclick="location.href = '{{ route("blogItem", ["slug"=>$blog->slug])}}';" class="blog-button">Read
                                            More <i class="fa-solid fa-right-long"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @include('app.pagination-strict',['paginator'=>$blogItems])
                    @endif
                <!-- <nav class="custome-pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript:void(0)" tabindex="-1">
                                <i class="fa-solid fa-angles-left"></i>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="javascript:void(0)">1</a>
                        </li>
                        <li class="page-item" aria-current="page">
                            <a class="page-link" href="javascript:void(0)">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">
                                <i class="fa-solid fa-angles-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav> -->
            </div>
            @if($sidebarExist)
                @include('app.blocks.sidebar')
            @endif
        </div>
    </div>
</section>
<!-- Blog Section End -->
@endsection
