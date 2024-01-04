<div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6" id="address_block_{{$key}}">
    <div class="address-box">
        <div>
            <div class="form-check">
                <input class="form-check-input" type="radio" data-id={{$key}} name="user_addresses"
                    id="user_address_main_{{$key}}" {{$main == 1 ? 'checked' : ''}}>
            </div>
            <div class="table-responsive address-table">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Address:</td>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <td>
                                <p id="user_address_{{$key}}">{{$address}}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="button-group">
            <button class="btn btn-sm add-button w-100 editAddressBtn" data-id={{$key}} >
                <i data-feather="edit"></i>
                Edit
            </button>
            <button class="btn btn-sm add-button w-100 removeAddressBtn" data-id={{$key}}>
                <i data-feather="trash-2"></i>
                Remove
            </button>
        </div>
    </div>
</div>