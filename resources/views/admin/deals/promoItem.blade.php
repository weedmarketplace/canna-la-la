@if($mode == 'add')
    <script type="text/javascript">
    if(typeof(itemPopup) != "undefined"){
        $( itemPopup ).one( "loaded", function(e){
            Loading.remove($('#add_item'));
        });
    }
    </script>
@endif
<style>
    .main-tab.fade:not(.show) {
        opacity: 0;
        display: none;
    }
</style>
@include('admin.blocks.uploader')
<div class="row">
    <div class="col-xxl-12">
        <!-- Tabbed dashboard card example-->
        <div class="card mb-4">
            <div class="card-header border-bottom">
                <!-- Dashboard card navigation-->
                <ul class="nav nav-tabs card-header-tabs main-tabs" id="dashboardNav" role="tablist">
                    <li class="nav-item mr-1"><a class="nav-link active" id="overview-pill" href="#overview" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">General</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="dashboardNavContent">
                    <!-- Dashboard Tab Pane 1-->
                    <form id="save-form" method="post">
                        <div class="tab-pane main-tab fade show active" id="overview" role="tabpanel" aria-labelledby="overview-pill">
                            <div class="container mt-4">
                                <div class="row">
                                    @csrf
                                    <input type="hidden" class="hidden_id" name="id" value="{{ $item->id }}" />
                                    <div class="col-lg-4 mb-4" style="display: inline-table;">
                                        <!-- Billing card 1-->
                                        <div class="card h-100 border-left-lg border-left-primary">
                                            <div class="card-body">
                                                <div class="small text-muted">Status</div>
                                                <div class="form-group">
                                                    <select class="form-select form-control customSelect" name="status" aria-label="">
                                                        <option @if($item->status == 1) selected @endif value="1">Active</option>
                                                        <option @if($item->status == 0) selected @endif value="1">Disabled</option>
                                                    </select>
                                                </div>
                                                <div class="h6">
                                                    <span class="small text-muted">Created:</span> 
                                                    <span class="float-right">{{$item->created_at}}</span> 
                                                </div>
                                                <div class="h6">
                                                    <span class="small text-muted">Used:</span> 
                                                    <span class="float-right" style="text-transform: capitalize;">{{$item->used}}</span> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8">
                                        <div class="card mb-4">
                                            <div class="card-header">Details</div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="code">Coupon code</label>
                                                        <input class="form-control" id="code" name="code" type="text" value="{{ $item->code }}" />
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-radio mr-2" style="display: inline-block;">
                                                            <input class="custom-control-input"  id="type_by_percent" value="percent" type="radio" name="type" @if($item->type == 'percent' || $item->type == null ) checked="" @endif >
                                                            <label class="custom-control-label" for="type_by_percent">Percentage discount</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="display: inline-block;">
                                                            <input class="custom-control-input" id="type_by_fixed" value="fixed" type="radio" name="type" @if($item->type == 'fixed') checked="" @endif>
                                                            <label class="custom-control-label" for="type_by_fixed">Fixed amount discount</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row" id="percent_discount" @if($item->type == 'fixed') style="display: none;" @endif>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="percent">Percentage discount %</label>
                                                        <input class="form-control" id="percent" name="percent" type="text" value="{{ $item->percent }}" />
                                                    </div>
                                                </div>
                                                <div class="form-row" id="fixed_discount" @if($item->type == 'percent' || $item->type == null ) style="display: none;" @endif>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="amount">Fixed amount discount</label>
                                                        <input class="form-control" id="amount" name="amount" type="text" value="{{ $item->amount }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input name="ftp" value="1" type="checkbox" id="ftp" {{$item->ftp == 1 ? 'checked' : ''}} >
                                                    <label for="ftp">Only registerd user one time</label>
                                                </div>
                                                <div id="limit_container"  @if($item->ftp == 1) style="display: none;" @endif>
                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-radio mr-2" style="display: inline-block;">
                                                                <input class="custom-control-input"  id="unlimited" value="0" type="radio" name="limit_type" @if($item->limit_type == 0 || $item->limit_type == null ) checked="" @endif >
                                                                <label class="custom-control-label" for="unlimited">Unlimited</label>
                                                            </div>
                                                            <div class="custom-control custom-radio" style="display: inline-block;">
                                                                <input class="custom-control-input" id="limit_fixed" value="1" type="radio" name="limit_type" @if($item->limit_type == 1) checked="" @endif>
                                                                <label class="custom-control-label" for="limit_fixed">Fixed count</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row" id="limit_count" @if($item->limit_type == 0 || $item->limit_type == null ) style="display: none;" @endif>
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="count">Coupon Total limit count</label>
                                                            <input class="form-control" id="count" name="count" type="text" value="{{ $item->count }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="my-2"></div>
                                            </div>
                                        </div>
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="container p-0">
                                                    <div class="form-group">
                                                        <div class="form-row">
                                                            <div class="form-group col-12">
                                                                <label class="small mb-1" for="title">Title</label>
                                                                <input class="form-control" id="title" name="title" type="text" value="{{ $item->title }}" />
                                                            </div>
                                                            <div class="form-group col-12">
                                                                <label class="small mb-1" for="descripition">Description</label>
                                                                <textarea  class="form-control textarea wysihtml5" id="descripition" name="description" rows="12">{{ $item->description }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-buttons">
                <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="save()" id="saveBtn" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

    $('#type_by_percent').on('change',function (){
        if( $('#type_by_percent').is(':checked') ){
            $('#fixed_discount').hide()
            $('#percent_discount').show()
        }
        else{
            $('#percent_discount').hide()
            $('#fixed_discount').show()
        }
    });

    $('#type_by_fixed').on('change',function (){
        if( $('#type_by_fixed').is(':checked') ){
            $('#percent_discount').hide()
            $('#fixed_discount').show()
        }
        else{
            $('#percent_discount').hide()
            $('#fixed_discount').show()
        }
    });

    $('#ftp').on('change',function (){
        if( $('#ftp').is(':checked') ){
            $('#limit_container').hide()
        }
        else{
            $('#limit_container').show()
        }
    });

    $('#unlimited').on('change',function (){
        if( $('#unlimited').is(':checked') ){
            $('#limit_count').hide()
        }
        else{
            $('#limit_count').show()
        }
    });

    $('#limit_fixed').on('change',function (){
        if( $('#limit_fixed').is(':checked') ){
            $('#limit_count').show()
        }
        else{
            $('#limit_count').hide()
        }
    });
});

function save(){
    Loading.add($('#saveItemBtn'));
    var data = $('#save-form').serializeFormJSON();

    $.ajax({
        type: "POST",
        url: "{{route('aPromoSave')}}",
        data: data,
        dataType: 'json',
        success: function(response){
            if(response.status == 0){
                if(response.messages){
                    toastr['error'](response.messages, 'Error');
                }else{
                    toastr['error'](response.errors, 'Error');
                }
            }
            if(response.status == 1){
                toastr['success']('Saved.', 'Success');
                window.datatable.ajax.reload(null, false);
                itemPopup.close();
            }
            Loading.remove($('#saveItemBtn'));
        },
        error: function(jqXHR, textStatus, errorThrown) {
            toastr['error'](errorThrown, 'Error');
            Loading.remove($('#saveItemBtn'));
        }
    });
}
</script>