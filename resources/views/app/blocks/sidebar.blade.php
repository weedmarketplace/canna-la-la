<div class="col-xxl-3 col-xl-4 d-none d-xl-block">
	<div class="p-sticky">
		@if(isset($recentBlogs) && count($recentBlogs) > 0)
		<div class="section-b-space">
			<div class="category-menu" id="recent-blog-con">
				<h3>Recent Post</h3>
				@foreach($recentBlogs as $recentBlog)
				<div class="recent-post-box">
					<div class="recent-box">
						<a href="{{ route('blogItem', ['slug'=>$recentBlog->slug])}}" class="recent-image">
							<img src="{{asset('images/blogItem/'.$recentBlog->img)}}" class="img-fluid blur-up lazyload" alt="{{$recentBlog->title}}">
						</a>

						<div class="recent-detail">
							<a href="{{ route('blogItem', ['slug'=>$recentBlog->slug])}}">
								<h5 class="recent-name">{{$recentBlog->title}}</h5>
							</a>
							<h6>{{ date('d M, Y', strtotime($recentBlog->published_at)) }}</h6>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endif
		@if(isset($dealsArray[3]) && count($dealsArray[3]) > 0)
			@foreach($dealsArray[3] as $deal)
				<div class="ratio_156">
					<div class="home-contain hover-effect">
						<img src="{{asset('images/dealSidebarSmall/'.$deal->img)}}" class="bg-img blur-up lazyload"
							alt="">
						<div class="home-detail p-top-left home-p-medium">
							<div>
								<h4 class="text-yellow text-exo home-banner">{{$deal->title}}</h4>
								<p class="mb-3">{{$deal->description}}</p>
								<h6 class="coupon-code">Use Code : {{$deal->code}}</h6>
								<button onclick="location.href = '{{route("shop")}}';" class="btn btn-animation btn-md mend-auto mt-3">
									Shop Now 
									<i class="fa-solid fa-arrow-right icon"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		@endif
		@if(isset($dealsArray[4]) && count($dealsArray[4]) > 0)
			@foreach($dealsArray[4] as $deal)
				<div class="ratio_medium section-t-space">
					<div class="home-contain hover-effect">
						<img src="{{asset('images/dealSidebarBig/'.$deal->img)}}" class="img-fluid blur-up lazyload"
							alt="">
						<div class="home-detail p-top-left home-p-medium">
							<div>
								<h4 class="text-yellow text-exo home-banner">{{$deal->title}}</h4>
								<p class="mb-3">{{$deal->description}}</p>
								<h6 class="coupon-code">Use Code : {{$deal->code}}</h6>
								<button onclick="location.href = '{{route("shop")}}';" class="btn btn-animation btn-md mend-auto mt-3">
									Shop Now 
									<i class="fa-solid fa-arrow-right icon"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		@endif
		@if($trandingProducts && count($trandingProducts) > 0)
		<div class="section-t-space">
			@include('app.blocks.trending_items')
		</div>
		@endif
	</div>
</div>