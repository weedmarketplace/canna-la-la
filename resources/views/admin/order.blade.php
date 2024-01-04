<!-- Main page content-->
<style>
.customSelect option[disabled] { color: #ccc; }
</style>
<div class="row">
    <div class="col-xxl-12">
        <!-- Tabbed dashboard card example-->
        <div class="card mb-4">
            <div class="card-header border-bottom">
                <!-- Dashboard card navigation-->
                <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                    <li class="nav-item mr-1"><a class="nav-link active" id="overview-pill" href="#overview" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Overview</a></li>
                    <li class="nav-item"><a class="nav-link" id="items-pill" href="#items" data-toggle="tab" role="tab" aria-controls="items" aria-selected="false">Item(s)</a></li>
                    <li class="nav-item"><a class="nav-link" id="log-pill" href="#log" data-toggle="tab" role="tab" aria-controls="log" aria-selected="false">Log</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="dashboardNavContent">
                    <!-- Dashboard Tab Pane 1-->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-pill">
                        <div class="container mt-4">
                            <!-- Account page navigation-->
                            <!-- <hr class="mt-0 mb-4" /> -->
                            <form id="save-form" method="post">
                                <div class="row">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{$item->id}}" />
                                    <div class="col-lg-4 mb-4" style="display: inline-table;">
                                        <div class="card h-100 border-left-lg border-left-primary">
                                            <div class="card-body">
                                                <div class="small text-muted">Status</div>
                                                <div class="form-group">
                                                    <select class="form-select form-control customSelect" name="status" aria-label="">
                                                        <option @if($item->status == 'processing') selected @endif value="processing">Processing</option>
                                                        <option @if($item->status == 'canceled') selected @endif value="canceled">Canceled</option>
                                                        <option @if($item->status == 'shipping') selected @endif value="shipping">Shipping</option>
                                                        <option @if($item->status == 'success') selected @endif value="success">Delivered</option>
                                                    </select>
                                                </div>
                                                <div class="small text-muted">Notes</div>
                                                <div class="form-group">
                                                    <textarea class="form-control" name="comment" id="comment" rows="3">{{$item->comment}}</textarea>
                                                </div>
                                                <div class="form-group" style="text-align:center;">
                                                    <button type="button" style="width: 100%;" onclick="saveOrder()"  id="saveOrderBtn" class="btn btn-success">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Billing card 1-->
                                        <div class="card h-100 border-left-lg border-left-primary mt-md-2">
                                            <div class="card-body">
                                                <div class="h6">
                                                    <span class="small text-muted">Order Id:</span> 
                                                    <span class="float-right">{{$item->sku}}</span> 
                                                </div>
                                                <div class="h6">
                                                    <span class="small text-muted">Created:</span> 
                                                    <span class="float-right">{{ date('d M, Y h:i A', strtotime($item->created_at)) }}</span> 
                                                </div>
                                                <div class="h6">
                                                    <span class="small text-muted">Payment method:</span> 
                                                    <span class="float-right" style="text-transform: capitalize;">{{$item->payment_method}}</span> 
                                                </div>
                                                <hr>
                                                <div class="h6">
                                                    <span class="small text-muted">Subtotal {{$item->qty}} Item(s):</span> 
                                                    <span class="float-right">${{ number_format($item->items_price, 2)}}</span> 
                                                </div>
                                                @if($item->used_coupon_discount)
                                                <div class="h6">
                                                    <span class="small text-muted">Coupon Discount:</span> 
                                                    <span class="float-right">(-) ${{ number_format($item->used_coupon_discount, 2)}}</span> 
                                                </div>
                                                @endif
                                                @if($item->sales_tax)
                                                <div class="h6">
                                                    <span class="small text-muted">Sales tax:</span> 
                                                    <span class="float-right">${{ number_format($item->sales_tax, 2)}}</span> 
                                                </div>
                                                @endif
                                                @if($item->excise_tax)
                                                <div class="h6">
                                                    <span class="small text-muted">Excise tax:</span> 
                                                    <span class="float-right">${{ number_format($item->excise_tax, 2)}}</span> 
                                                </div>
                                                @endif
                                                @if($item->delivery_fee)
                                                <div class="h6">
                                                    <span class="small text-muted">Shipping:</span> 
                                                    <span class="float-right">${{ number_format($item->delivery_fee, 2)}}</span> 
                                                </div>
                                                @endif
                                                <hr>
                                                <div class="h6">
                                                    <span class="small text-muted">Total:</span> 
                                                    <span class="float-right">${{ number_format($item->total, 2)}}</span> 
                                                </div>
                                            </div>
                                        </div>
                                        @if($item->used_coupon_discount)
                                        <div class="card h-100 border-left-lg border-left-primary mt-md-2">
                                            <div class="card-body">
                                                <div class="h6">
                                                    <span class="small text-muted">Used coupon:</span> 
                                                    <span class="float-right">{{$item->used_coupon_code}}</span> 
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-xl-8">
                                        <!-- Account details card-->
                                        <div class="card mb-4">
                                            <div class="card-header"></div>
                                            <div class="card-body">
                                                <form>
                                                    <!-- Form Group (username)-->
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="userid">User ID</label>
                                                        <input class="form-control" id="userid" readonly disabled name="userid" type="text" value="{{$item->owner_id ? $item->owner_id : 'Guest'}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="fullname">Fullname</label>
                                                        <input class="form-control" id="fullname" readonly disabled name="fullname" type="text" value="{{$item->fullname}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="phone">Phone</label>
                                                        <input class="form-control" id="phone" readonly disabled name="phone" type="text" value="{{$item->phone}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="email">Email</label>
                                                        <input class="form-control" id="email" readonly disabled name="email" type="text" value="{{$item->email}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="address">Address</label>
                                                        <input class="form-control" id="address" readonly disabled name="address" type="text" value="{{$item->address}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="description">Client notes</label>
                                                        <textarea class="form-control" name="comment" readonly disabled rows="3">{{$item->notes}}</textarea>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="items" role="tabpanel"  aria-labelledby="items-tab">
                    <div class="datatable table-responsive">
                            <table class="table table-bordered table-hover"  width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Info</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Image</th>
                                        <th>Info</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(count($orderItems) > 0)
                                    @foreach($orderItems as $orderItem)
                                    <tr>
                                        <td><img class="img-fluid" src="{{$orderItem->imagePath}}" alt=""></td>
                                        <td>
                                            <div><b>Title:</b> {{$orderItem->title}}</div>
                                            <div><b>Category:</b> {{$orderItem->category_title}}</div>
                                            <div><b>Weight:</b> {{$orderItem->unit}}</div>
                                            <div>{!!$orderItem->inStock > 0 ? '<b>In stock: </b>'. $orderItem->inStock : '<b>In stock: </b> Out of stock'!!}</div>
                                            <div><a href="{{$orderItem->route}}" target="_blank">Show product</a></div>
                                        </td>
                                        <td>
                                            @if($orderItem->discount > 0)
                                                <div>
                                                    <b>Price:</b> ${{ number_format($orderItem->sell_price, 2)}}
                                                    <del>${{ number_format($orderItem->price, 2)}}</del>
                                                </div>
                                                <div><b>Discount:</b> {{$orderItem->discount}}%</div>
                                            @else
                                                <div><b>Price:</b> ${{ number_format($orderItem->sell_price, 2)}}</div>
                                            @endif
                                        </td>
                                        <td>X {{$orderItem->qty}}</td>
                                        <td>${{ number_format($orderItem->total, 2)}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-pill">
                        <div class="datatable table-responsive">
                            <table class="table table-bordered table-hover"  width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Event</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Event</th>
                                        <th>Time</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if($logs)
                                    @foreach ($logs as $log)
                                    <?php $created_at = explode(' ',$log->created_at); ?> 
                                    <tr>
                                        <td><?= $created_at[0] ?></td>
                                        <td>
                                            @if($log->type == 'status_changed')
                                                <i class="mr-2 text-green" data-feather="tag"></i>
                                                Status changed from:
                                                <?php $payload = json_decode($log->data); echo $payload->old_status; ?>
                                                - to: <?php echo $payload->new_status; ?>
                                            @endif
                                            @if($log->type == 'order_created')
                                            <i class="mr-2 text-green" data-feather="zap"></i>
                                            Order created
                                            @endif
                                            @if($log->type == 'order_paid')
                                            <i class="mr-2 text-purple" data-feather="shopping-cart"></i>
                                            Order paid
                                            @endif
                                        </td>
                                        <td><?= $created_at[1] ?></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-buttons">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" onclick="save()"  id="saveItemBtn" class="btn btn-success" data-dismiss="modal">Save</button> -->
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        feather.replace();
    });
    function saveOrder() {
        Loading.add($('#saveOrderBtn'));
        var data = $('#save-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('saveOrder') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.message, 'Error');
                }
                if (response.status == 1) {
                    toastr['success'](response.message, 'Success');
                    if(window.datatable){
                        window.datatable.ajax.reload(null, false);
                    }
                    itemPopup.close();
                }
                Loading.remove($('#saveOrderBtn'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown, 'Error');
                Loading.remove($('#saveOrderBtn'));
            }
        });
    }
</script>