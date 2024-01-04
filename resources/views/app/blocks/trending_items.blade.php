@if($trandingProducts && count($trandingProducts) > 0)
<div class="category-menu section-t-space">
    <h3>Trending Products</h3>
    <ul class="product-list border-0 p-0 d-block ">
        @foreach($trandingProducts as $tp)
        <li>
            <div class="offer-product">
                <a href="{{ route('product', ['slug'=>$tp->url])}}" class="offer-image">
                    <img src="{{$tp->imagePath}}" class="blur-up lazyload" alt="{{$tp->title}}">
                </a>

                <div class="offer-detail">
                    <div>
                        <a href="{{ route('product', ['slug'=>$tp->url])}}" class="text-title">
                            <h6 class="name">{{$tp->title}}</h6>
                        </a>
                        <span>{{$tp->unit}}</span>
                        <h6 class="price theme-color">$ {{$tp->effective_price}}</h6>
                    </div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endif