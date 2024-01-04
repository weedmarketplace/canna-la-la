<div class="{{$classContainer}}">
	<div class="product-box-3 h-100 {{$classType == 'white' ? 'theme-bg-white' : ''}}">
		<div class="product-header">
			<div class="product-image">
				<a href="{{ route('product', ['slug'=>$product->url])}}">
					<img src="{{$product->imagePath}}" class="img-fluid blur-up lazyload" alt="{{$product->title}}">
				</a>

				<div class="product-header-top">
					<button class="btn wishlist-button close_button" data-price-id="{{$product->price_id}}" data-product-id="{{$product->id}}">
						<i data-feather="x"></i>
					</button>
				</div>
			</div>
		</div>
		<div class="product-footer">
			<div class="product-detail">
				<div class="product-info">
					<span class="span-name m-0">{{$product->category_title}}</span>
					<span class="unit m-0">{{$product->unit}}</span>
				</div>
				<a href="{{ route('product', ['slug'=>$product->url])}}">
					<h5 class="name">{{$product->title}}</h5>
				</a>
				@if($product->cannabinoid)
					<h6 class="cannabinoid unit">{{$product->cannabinoid}}</h6>
				@else
					<h6 class="cannabinoid unit cannabinoid-placeholder">Placeholder</h6>
				@endif
				<h5 class="price"><span class="theme-color">${{$product->effective_price}}</span> @if($product->discount > 0)<del>${{$product->price}}</del> @endif
				</h5>

				<div class="add-to-cart-box {{$classType == 'white' ? '' : 'bg-white'}} mt-2">
					<button data-price-id="{{$product->price_id}}" data-max-qty="{{$product->qty}}" data-product-id="{{$product->id}}" class="btn btn-add-cart addcart-button">Add
						<span class="add-icon bg-light-gray">
							<i class="fa-solid fa-plus"></i>
						</span>
					</button>
					<div class="cart_qty qty-box">
						<div class="input-group bg-white">
							<button type="button" data-price-id="{{$product->price_id}}" data-product-id="{{$product->id}}" class="qty-left-minus bg-gray"
								data-type="minus" data-field="">
								<i class="fa fa-minus" aria-hidden="true"></i>
							</button>
							<input class="form-control input-number qty-input" readonly type="text" name="quantity" value="0">
							<button type="button" data-max-qty="{{$product->qty}}" data-price-id="{{$product->price_id}}" data-product-id="{{$product->id}}" class="qty-right-plus bg-gray"
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