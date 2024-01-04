@extends('app.layouts.app')
@section('content')
<!-- Cart Section Start -->
<section class="cart-section section-b-space" id="cartPageIdentifier">
    <div class="container-fluid-lg">
        <div class="row g-sm-5 g-3">
            <div class="col-xxl-9">
                <div class="cart-table">
                    <div class="table-responsive-xl">
                        <table class="table">
                            <tbody>
                                @if(isset($products) && count($products) > 0)
                                    @foreach($products as $product)
                                        <tr class="product-box-contain">
                                            <td class="product-detail">
                                                <div class="product border-0">
                                                    <a href="{{$product->route}}" class="product-image">
                                                        <img src="{{$product->imagePath}}" class="img-fluid blur-up lazyload" alt="">
                                                    </a>
                                                    <div class="product-detail">
                                                        <ul>
                                                            <li class="name limitTextLi">
                                                                <a class="limitText" href="{{$product->route}}">{{$product->title}}</a>
                                                            </li>
                                                            <li class="text-content">{{$product->category_title}}</li>
                                                            <li class="text-content"><span class="text-title">{{$product->unit}}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="price">
                                                <h4 class="table-title text-content">Price</h4>
                                                <h5><span class="sell_price" data-amount="{{$product->effective_price}}">@currency($product->effective_price)</span>@if($product->discount > 0)<del class="text-content">@currency($product->price)</del>@endif</h5>
                                                @if($product->discount > 0)
                                                <h6 class="theme-color">You Save : @currency($product->price - $product->effective_price)</h6>
                                                @endif
                                            </td>

                                            <td class="quantity">
                                                <h4 class="table-title text-content">Qty</h4>
                                                <div class="quantity-price">
                                                    <div class="cart_qty">
                                                        <div class="input-group">
                                                            <button data-price-id="{{$product->price_id}}" data-product-id="{{$product->id}}" type="button" class="btn qty-left-minus"
                                                                data-type="minus" data-field="">
                                                                <i class="fa fa-minus ms-0" aria-hidden="true"></i>
                                                            </button>
                                                            <input class="form-control input-number qty-input" readonly type="text"
                                                                name="quantity" value="{{$product->cart_data['qty']}}">
                                                            <button data-price-id="{{$product->price_id}}" data-product-id="{{$product->id}}" type="button" class="btn qty-right-plus" data-type="plus" data-field="">
                                                                <i class="fa fa-plus ms-0" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="subtotal">
                                                <h4 class="table-title text-content">Total</h4>
                                                <h5><span class="product_sub_total">@currency($product->subTotal)</span></h5>
                                            </td>

                                            <td class="save-remove">
                                                <h4 class="table-title text-content">Action</h4>
                                                <a class="save notifi-wishlist" data-price-id="{{$product->price_id}}" data-product-id="{{$product->id}}" href="javascript:void(0)">Save for later</a>
                                                <a class="remove close_button remove-product" data-price-id="{{$product->price_id}}" data-product-id="{{$product->id}}" href="javascript:void(0)">Remove</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3">
                <div class="summery-box p-sticky">
                    <div class="summery-header">
                        <h3>Cart Total</h3>
                    </div>

                    <div class="summery-contain">
                        <div class="coupon-cart">
                            <h6 class="text-content mb-2">Coupon Apply</h6>
                            <div class="mb-3 coupon-box input-group">
                                <input type="text" class="form-control" id="couponCode"
                                    placeholder="Enter Coupon Code Here...">
                                <button class="btn-apply">Apply</button>
                                <div id="coupon_error_con"></div>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <h4>Subtotal</h4>
                                <h4 class="price"><span id="mainSubTotal" data-amount="{{$cartSummarize['subTotal']}}">@currency($cartSummarize['subTotal'])</span></h4>
                            </li>
                            <li class="spectial">
                                <h4>Coupon Discount</h4>
                                <h4 class="price">(-) <span id="couponDiscount" data-size='{{$couponDiscountData ? $couponDiscountData["size"] : ""}}'  data-type='{{$couponDiscountData ? $couponDiscountData["type"] : ""}}'>@if(isset($couponDiscountData['discountedAmount'])) @currency($couponDiscountData['discountedAmount']) @else $0.00 @endif</span></h4>
                            </li>
                            @if($taxConfig['sales_tax'] > 0 && isset($cartSummarize['salesTaxAmount']))
                            <li class="align-items-start">
                                <h4>Sales tax</h4>
                                <h4 class="price text-end"><span id="sales_tax" data-percent='{{$taxConfig['sales_tax']}}'>@currency($cartSummarize['salesTaxAmount'])</span></h4>
                            </li>
                            @endif
                            @if($taxConfig['excise_tax'] > 0 && isset($cartSummarize['exciseTaxAmount']))
                            <li class="align-items-start">
                                <h4>Excise tax</h4>
                                <h4 class="price text-end"><span id="excise_tax" data-percent='{{$taxConfig['excise_tax']}}'>@currency($cartSummarize['exciseTaxAmount'])</span></h4>
                            </li>
                            @endif
                            @if($taxConfig['delivery_fee'] > 0)
                            <li class="align-items-start">
                                <h4>Shipping</h4>
                                <h4 class="price text-end"><span id="delivery_fee" data-amount="{{$taxConfig['delivery_fee']}}">@currency($taxConfig['delivery_fee'])</span></h4>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <ul class="summery-total">
                        <li class="list-total border-top-0">
                            <h4>Total (USD)</h4>
                            <h4 class="price theme-color"><span id="mainTotal" data-amount="{{$cartSummarize['totalPrice']}}">@currency($cartSummarize['totalPrice'])</span></h4>
                        </li>
                    </ul>

                    <div class="button-group cart-button">
                        <ul>
                            <li>
                                <button onclick="location.href = '{{ route('checkout') }}';"
                                    class="btn btn-animation proceed-btn fw-bold">Process To Checkout</button>
                            </li>

                            <li>
                                <button onclick="location.href = '{{ route('shop') }}';"
                                    class="btn btn-light shopping-button text-dark">
                                    <i class="fa-solid fa-arrow-left-long"></i>Return To Shopping</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Cart Section End -->
@endsection