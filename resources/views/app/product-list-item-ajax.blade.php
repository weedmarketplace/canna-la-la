@if(@$feed)
	@if($gridClass== 'search')
	<div class="row g-sm-4 g-3 row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-2 product-list-section load_feed">
	@else
	<div class="row g-sm-4 g-3 {{$gridClass}} row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section load_feed">
	@endif
	@foreach ($feed as $product)
		@include('app.product-list-item', [$product])
	@endforeach
	</div>
	@include('app.pagination',['paginator'=>$feed, 'paginatorClass'=>'product_feed'])
@endif