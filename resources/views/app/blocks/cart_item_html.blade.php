<li class="product-box-contain">
    <div class="drop-cart">
        <a href="{{$product->route}}" class="drop-image">
            <img src="{{$product->imagePath}}" class="blur-up lazyload" alt="">
        </a>

        <div class="drop-contain" style="min-width: 180px;">
            <a href="{{$product->route}}">
                <h5>{{$product->title}}</h5>
            </a>
            <h6><span>{{$qty}} x</span> @currency($product->effective_price)</h6>
            <h6><span>{{$product->unit}}</h6>
            <button class="close-button close_button remove-product" data-price-id="{{$product->price_id}}" data-product-id="{{$product->id}}">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
</li>