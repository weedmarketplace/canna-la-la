@extends('app.layouts.app')
@section('content')
<!-- Checkout section Start -->
<section class="checkout-section-2 section-b-space" id="checkoutPageIdentifier">
    <form id="checkout_form">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3">
                <div class="col-lg-8">
                    <div class="left-sidebar-checkout">
                        <div class="checkout-detail-box">
                            <ul>
                                <li>
                                    <div class="checkout-icon">
                                        <lord-icon target=".nav-item" src="https://cdn.lordicon.com/ggihhudh.json"
                                            trigger="loop-on-hover"
                                            colors="primary:#121331,secondary:#646e78,tertiary:#0baf9a"
                                            class="lord-icon">
                                        </lord-icon>
                                    </div>
                                    <div class="checkout-box">
                                        @if(Auth::guard('web')->check())
                                        <div class="checkout-title">
                                            <h4>Delivery Info</h4>
                                            @if(Auth::guard('web')->user()->addresses)
                                            <button id="addNewAddressBtn" class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"><i data-feather="plus"
                                                class="me-2"></i> Add New Address</button>
                                            @endif
                                        </div>

                                        <div class="checkout-detail">
                                            <div class="row g-4" id="addresses_container">
                                                @if(Auth::guard('web')->user()->addresses)
                                                    @foreach(json_decode(Auth::guard('web')->user()->addresses) as $key => $address)
                                                        @include('app.profile.addressBlockCheckout', ['key' => $key, 'address' => $address->address, 'main' => $address->main])
                                                    @endforeach
                                                @else
                                                    <div class="col-xxl-6 col-lg-12 col-md-6">
                                                        <div class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                            <input type="text" class="form-control" required name="user_delivery_address" id="user_delivery_address_new" placeholder="Add address">
                                                            <label for="credit2">Address</label>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @else
                                            <div class="checkout-title">
                                                <h4>Delivery Info</h4>
                                            </div>

                                            <div class="checkout-detail">
                                                <div class="row g-2">
                                                    <div class="col-xxl-6 col-lg-12 col-md-6">
                                                        <div class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                            <input type="text" class="form-control" required name="delivery_name" id="delivery_name" placeholder="Full name">
                                                            <label for="credit2">Fullname</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-lg-12 col-md-6">
                                                        <div class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                            <input type="text" class="form-control" required name="delivery_phone" id="delivery_phone" placeholder="Phone">
                                                            <label for="credit2">Phone</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-lg-12 col-md-6">
                                                        <div class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                            <input type="text" class="form-control" required name="delivery_email" id="delivery_email" placeholder="Email">
                                                            <label for="credit2">Email</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6 col-lg-12 col-md-6">
                                                        <div class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                            <input type="text" class="form-control" required name="delivery_address" id="delivery_address" placeholder="Address">
                                                            <label for="credit2">Address</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <div class="mb-md-4 mt-4 custom-form">
                                                <label for="contact_message" class="form-label">Notes</label>
                                                <div class="custom-textarea">
                                                    <textarea id="delivery_notes" name="delivery_notes" class="form-control"
                                                        placeholder="Enter notes" rows="6"></textarea>
                                                    <!-- <i class="fa-solid fa-message"></i> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkout-icon">
                                        <lord-icon target=".nav-item" src="https://cdn.lordicon.com/qmcsqnle.json"
                                            trigger="loop-on-hover" colors="primary:#0baf9a,secondary:#0baf9a"
                                            class="lord-icon">
                                        </lord-icon>
                                    </div>
                                    <div class="checkout-box">
                                        <div class="checkout-title">
                                            <h4>Payment Option</h4>
                                        </div>

                                        <div class="checkout-detail">
                                            <div class="accordion accordion-flush custom-accordion"
                                                id="accordionFlushExample">
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="flush-headingFour">
                                                        <div class="accordion-button collapsed"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseFour">
                                                            <div class="custom-form-check form-check mb-0">
                                                                <label class="form-check-label" for="cash"><input
                                                                        class="form-check-input mt-0" type="radio"
                                                                        name="payment_method" value="cash" id="cash" checked> Cash
                                                                    On Delivery</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="flush-headingThree">
                                                        <div class="accordion-button collapsed"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseThree">
                                                            <div class="custom-form-check form-check mb-0">
                                                                <label class="form-check-label" for="cashless"><input
                                                                        class="form-check-input mt-0" type="radio"
                                                                        name="payment_method" value="cashless" id="cashless">Cash
                                                                    Less</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="right-side-summery-box">
                        <div class="summery-box-2">
                            <div class="summery-header">
                                <h3>Order Summery</h3>
                            </div>
                            @if(isset($products) && count($products) > 0)
                            <ul class="summery-contain">
                                @foreach($products as $product)
                                <li class="product-box-contain" data-price-id="{{$product->price_id}}" data-qty="{{$product->cart_data['qty']}}" data-sell-price="{{$product->effective_price}}" data-product-id="{{$product->id}}">
                                    <img src="{{$product->imagePath}}"
                                        class="img-fluid blur-up lazyloaded checkout-image" alt="">
                                    <h4>{{$product->title}} <span>X {{$product->cart_data['qty']}}</span> <span style="display: block;">{{$product->unit}}</span></h4>
                                    <h4 class="price"><span class="product_sub_total">@currency($product->subTotal)</span></h4>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                            <div class="summery-contain" style="margin-top: 15px;">
                                <div class="coupon-cart">
                                    <h6 class="text-content mb-2">Coupon Apply</h6>
                                    <div class="mb-3 coupon-box input-group">
                                        <input type="text" class="form-control" id="couponCode"
                                            placeholder="Enter Coupon Code Here...">
                                        <button id="coupon_code" class="btn-apply">Apply</button>
                                        <div id="coupon_error_con"></div>
                                    </div>
                                </div>
                            </div>
                            <ul class="summery-total">
                                <li>
                                    <h4>Subtotal</h4>
                                    <h4 class="price"><span id="mainSubTotal">@currency($cartSummarize['subTotal'])</span></h4>
                                </li>
                                <li class="spectial">
                                    <h4>Coupon/Code</h4>
                                    <h4 class="price">(-) <span id="couponDiscount" data-coupon-id='{{$couponDiscountData ? $couponDiscountData["id"] : ""}}' data-size='{{$couponDiscountData ? $couponDiscountData["size"] : ""}}'  data-type='{{$couponDiscountData ? $couponDiscountData["type"] : ""}}'>@if(isset($couponDiscountData['discountedAmount'])) @currency($couponDiscountData['discountedAmount']) @else $0.00 @endif</span></h4>
                                </li>
                                @if($taxConfig['sales_tax'] > 0 && isset($cartSummarize['salesTaxAmount']))
                                <li>
                                    <h4>Sales tax</h4>
                                    <h4 class="price"><span id="sales_tax" data-percent='{{$taxConfig['sales_tax']}}'>@currency($cartSummarize['salesTaxAmount'])</span></h4>
                                </li>
                                @endif
                                @if($taxConfig['excise_tax'] > 0 && isset($cartSummarize['exciseTaxAmount']))
                                <li>
                                    <h4>Excise tax</h4>
                                    <h4 class="price"><span id="excise_tax" data-percent='{{$taxConfig['excise_tax']}}'>@currency($cartSummarize['exciseTaxAmount'])</span></h4>
                                </li>
                                @endif
                                @if($taxConfig['delivery_fee'] > 0)
                                <li style="padding-top:8px;padding-bottom:0px;">
                                    <h4 style="font-weight: 400; color:#222;">Shipping</h4>
                                    <h4 class="price" style="font-weight: 400; color:#222;"><span id="delivery_fee" data-amount="{{$taxConfig['delivery_fee']}}">@currency($taxConfig['delivery_fee'])</span></h4>
                                </li>
                                @endif
                                <li class="list-total">
                                    <h4>Total (USD)</h4>
                                    <h4 class="price"><span id="mainTotal" data-amount="{{$cartSummarize['totalPrice']}}">@currency($cartSummarize['totalPrice'])</span></h4>
                                </li>
                            </ul>
                        </div>

                        <button id="orderSubmitBtn" class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold">Place Order</button>
                        <div id="cartErrors"></div> 
                    </div>
                </div>
            </div>
        </div>
    </form>    
</section>
@if(Auth::guard('web')->check() && Auth::guard('web')->user()->addresses)
<!-- Add address modal box start -->
<div class="modal fade theme-modal" id="addAddress" tabindex="-1" aria-labelledby="addAddressModal"
        aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a new address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="addAddress-form">
                @csrf
                <div class="modal-body">
                    <div class="form-floating mb-4 theme-form-floating">
                        <textarea class="form-control" name="address" id="address" style="height: 100px"></textarea>
                        <label for="address">Enter Address</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="saveAddressBtn" class="btn theme-bg-color btn-md text-white">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add address modal box end -->
@endif
<!-- Checkout section End -->
@push('script')
<script src="{!! asset('assets/js/lusqsztk.js') !!}"></script>
<script>
    $(document).ready(function() {
        $('#checkout_form').submit(function(event) {
        // $('#orderSubmitBtn').on('click', function(event) {
            event.preventDefault();
            btn = $('#orderSubmitBtn');
            Loading.add(btn);

            $('#checkoutPageIdentifier span.error').remove();
            $( "#cartErrors").html('');
            
            var formData = new FormData();
            total = $('#mainTotal').data('amount');
            formData.append('total', total);
            @if(Auth::guard('web')->check())
                if($('#user_delivery_address_new').length > 0){
                    formData.append('address', $('#user_delivery_address_new').val());
                    formData.append('new_address', 1);
                }else{
                    formData.append('new_address', 0);
                    formData.append('address', $('input[name=user_delivery_address]:checked').val());
                }
            @else
                formData.append('delivery_name', $('#delivery_name').val());
                formData.append('delivery_phone', $('#delivery_phone').val());
                formData.append('delivery_email', $('#delivery_email').val());
                formData.append('delivery_address', $('#delivery_address').val());
            @endif
            
            formData.append('delivery_notes', $('#delivery_notes').val());
            
            var payment_method = $('input[name="payment_method"]:checked').val();
            formData.append('payment_method', payment_method);
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                type: 'POST',
                url: "{{ route('submitOrder') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if(response.status == 1){
                        window.location = response.redirect;
                    }
                    Loading.remove(btn);
                },
                error: function(response) {
                    if(response.responseJSON.errors){
                        errors = response.responseJSON.errors
                        itemHasError = false
                        $.each( errors, function( key, value ) {
                            if($("#"+key).length > 0){
                                $( "#"+key ).after( '<span class="error">'+value+'</span>' );
                            }else{
                                if(key == 'item'){
                                    itemHasError = true
                                    eachError = value[0];
                                    if(eachError.product_id && eachError.price_id){
                                        $(".product-box-contain[data-product-id='" + eachError.product_id + "'][data-price-id='" + eachError.price_id + "']").css('background-color', '#d6d6d9');
                                        $('<span class="error">'+eachError.message+'</span>').insertAfter(".product-box-contain[data-product-id='" + eachError.product_id + "'][data-price-id='" + eachError.price_id + "']");
                                    }
                                }else{
                                    if(key != 'claerCart'){
                                        $( "#cartErrors").html( '<span class="error">'+value+'</span>');
                                    }
                                }
                                if(key == 'claerCart'){
                                    $( "#cartErrors").append( '<a href="'+value+'"> Clear cart</a>');
                                }
                            }
                        });
                        if(itemHasError){
                            $('html, body').animate({
                                scrollTop: $(".summery-contain").offset().top - 200
                            }, 500);
                        }
                    }else{
                        $( "#cartErrors").html( '<label class="error">Something wrong, pls try again!</label>' );
                    }
                    Loading.remove(btn);
                    return;
                }
            });
        });
    });
</script>
@if(Auth::guard('web')->check() && Auth::guard('web')->user()->addresses)
    <script>
        $( document ).on( "click", "#addNewAddressBtn", function(event) {
            event.preventDefault();

            $('#addAddress #address').val('');
            $('#addAddress').modal('show');
            return;
        });
        $('#addAddress-form').submit(function(event) {
            event.preventDefault();
            btn = $('#addNewAddressBtn');
            Loading.add(btn);
            var formData = new FormData(this);

            $('#addAddress-form span.error').remove();
            $.ajax({
                type: 'POST',
                url: "{{ route('saveAddressCheckout') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if(response.status == 0){
                        Loading.remove(btn);
                        alert(response.message);
                        return;
                    }
                    $('#addresses_container').append(response.newAddressHtml);
                    $('#addAddress').modal('hide');
                    Loading.remove(btn);
                },
                error: function(response) {
                    if(response.responseJSON && response.responseJSON.errors){
                        errors = response.responseJSON.errors
                        $.each( errors, function( key, value ) {
                            if($("#addAddress-form [name="+key+"]").length > 0){
                                $( "#addAddress-form [name="+key+"]" ).after( '<span class="error">'+value+'</span>' );
                            }
                        });
                    }else{
                        alert('Something wrong. pls try again');
                    }
                    Loading.remove(btn);
                }
            });
        });
    </script>
@endif
@endpush
@endsection