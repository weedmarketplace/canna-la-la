<div>
	<div class="product-box-3 h-100 wow fadeInUp">
		<div class="product-header">
			<div class="product-image">
				<a href="{{ route('product', ['slug'=>$product->url])}}">
					<img src="{{$product->imagePath}}"
						class="img-fluid blur-up lazyload" alt="">
				</a>

				<ul class="product-option">
					<li data-bs-toggle="tooltip" data-bs-placement="top" title="View" data-product-id="{{$product->id}}">
					<!-- data-bs-toggle="modal" data-bs-target="#view" -->
						<a href="javascript:void(0)" class="view-product-link" >
							<i data-feather="eye"></i>
						</a>
					</li>
					
					<li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
						<a href="javascript:void(0)" data-price-id="{{$product->price_id}}" data-product-id="{{$product->id}}" class="notifi-wishlist">
							<i data-feather="heart"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="product-footer">
			<div class="product-detail">
				<span class="span-name">{{$product->category_title}} <h6 class="unit">{{$product->unit}}</h6></span>
				<a href="{{ route('product', ['slug'=>$product->url])}}">
					<h5 class="name">{{$product->title}}</h5>
				</a>
				<p class="text-content mt-1 mb-2 product-content">{!!$product->description!!}</p>
				<h6 class="unit">{{$product->unit}}</h6>
				<h5 class="price"><span class="theme-color">${{$product->effective_price}}</span> @if($product->discount > 0)<del>${{$product->price}}</del> @endif
				</h5>
				<div class="add-to-cart-box bg-white">
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