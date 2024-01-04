@if($mode == 'add')
    <script type="text/javascript">
        if(typeof(itemPopup) != "undefined"){
            $( itemPopup ).one( "loaded", function(e){
                console.log('asdasd')
                Loading.remove($('#add_item'));
            });
        }
    </script>
@endif
<form id="save-item-form" method="post">
    <div class="row">
        <input type="hidden" class="hidden_id" name="id" value="{{ $item->id }}" />
        @csrf
        <div class="col-lg-4 mb-4" style="display: inline-table;">
            <div class="card h-100 border-left-lg border-left-primary">
                <div class="card-body">
                    <div class="h6">
                        <span class="small text-muted">Birthday:</span> 
                        <span class="float-right">{{$item->dob}}</span> 
                    </div>
                    <div class="h6">
                        <span class="small text-muted">Registerd at:</span> 
                        <span class="float-right">{{$item->created_at}}</span> 
                    </div>
                    <div class="h6">
                        <span class="small text-muted">Order count:</span> 
                        <span class="float-right">{{$item->orderCount}}</span> 
                    </div>
                    <div class="h6">
                        <span class="small text-muted">Order total:</span> 
                        <span class="float-right">${{ number_format($item->orderTotalSum, 2)}}</span> 
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-body">
                        <!-- Form Group (username)-->
                        <div class="form-group">
                            <label class="small mb-1" for="userid">User ID</label>
                            <input class="form-control" id="userid" readonly disabled name="userid" type="text" value="{{$item->id ? $item->id : 'Guest'}}" />
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="fullname">Fullname</label>
                            <input class="form-control" id="fullname" readonly disabled name="fullname" type="text" value="{{$item->name}}" />
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="phone">Phone</label>
                            <input class="form-control" id="phone" readonly disabled name="phone" type="text" value="{{$item->phone}}" />
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="email">Email</label>
                            <input class="form-control" id="email" readonly disabled name="email" type="text" value="{{$item->email}}" />
                        </div>
                        @if($item->userAddresses)
                        <div class="form-group">
                            <label class="small mb-1" for="address">Addresses</label>
                            @foreach($item->userAddresses as $address)
                                <input class="form-control mb-3" id="address" readonly disabled name="address" type="text" value="{{$address->address}} {{$address->main ? '(main)' : ''}}" />
                            @endforeach
                        </div>
                        @endif
                        <!-- <div class="form-group">
                            <label class="small mb-1" for="description">Client notes</label>
                            <textarea class="form-control" name="comment" readonly disabled rows="3">{{$item->notes}}</textarea>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal-buttons">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>