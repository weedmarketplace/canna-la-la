<div class="col-xxl-6 col-lg-12 col-md-6">
    <div class="delivery-address-box">
        <div>
            <div class="form-check">
                <input class="form-check-input" {{$main == 1 ? 'checked' : ''}} type="radio" name="user_delivery_address" value="{{$address}}"
                    id="delivery_address_{{$key}}">
            </div>
            <ul class="delivery-address-detail">
                <li>
                    <p class="text-content">
                        <span class="text-title">Address: </span>
                        {{$address}}
                    </p>
                </li>
            </ul>
        </div>
    </div>
</div>