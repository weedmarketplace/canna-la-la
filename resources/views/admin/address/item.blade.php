@if($mode == 'add')
    <script type="text/javascript">
        if(typeof(itemPopup) != "undefined"){
            $( itemPopup ).one( "loaded", function(e){
                Loading.remove($('#add_item'));
            });
        }
    </script>
@endif
<form id="save-item-form" method="post">
    <div class="row">
        <input type="hidden" class="hidden_id" name="id" value="{{ $item->id }}" />
        @csrf
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">Image</div>
                <div class="card-body text-center">
                    <div class="image-upload-container" id="cover">
                        <div class="image-part">
                            <?php
                            $images = DB::table('images')->where('id',$item->image_id)->select('filename','ext')->first()
                            ?>
                            <img class="thumbnail"
                                 src="@if ($item->image_id) {{ asset('images/backendSmall/'.$images->filename.'.'.$images->ext) }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif" />
                            <input  type="hidden"  name="img" class="cover" value="@if ($item->image_id) {{ $item->image_id }} @endif" />
                        </div>
                        <div class="image-action @if ($item->image) fileExist @else fileNotExist @endif">
                            <div>
                                <span >size: ({{$item->pagename == 'faq' ? '342x200' : '342 x 200'}}) </span>
                            </div>
                            <div class="img-not-exist">
                                <span id="uploadBtn" class="btn btn-success">Select image </span>
                            </div>
                            <div class="img-exist">
                                <span class="btn btn-danger remove-image">Remove </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label class="small mb-1" for="phone">Phone</label>
                            <input class="form-control"  name="phone" type="text"
                                   placeholder="Phone" value="{{ $item->phone }}" />
                        </div>
                        <div class="form-group col-6">
                            <label class="small mb-1" for="slug">Slug</label>
                            <input class="form-control" disabled type="text"  value="{{ $item->slug }}" />
                        </div>
                    </div>
                </div>
                <div class="card-header border-bottom" style="background-color:#fff;">
                    <ul class="nav nav-tabs card-header-tabs" id="dashboardNav"
                        role="tablist">
                        @foreach (Session::get('bLangs') as $index => $lang)
                            <li class="nav-item mr-1"><a
                                    class="nav-link @if ($index == 0) active @endif"
                                    id="multi_content_{{ $lang['lang'] }}-pill"
                                    href="#multi_content_{{ $lang['lang'] }}"
                                    data-toggle="tab" role="tab"
                                    aria-controls="multi_content_{{ $lang['lang'] }}"
                                    aria-selected="@if ($index == 0) true @else false @endif">{{ $lang['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="dashboardNavContent">
                        @foreach (Session::get('bLangs') as $index => $lang)
                                <?php $name = 'name_' . $lang['lang']; ?>
                                <?php $description = 'description_' . $lang['lang']; ?>
                                <?php $address = 'address_' . $lang['lang']; ?>
                                <?php $date = 'date_' . $lang['lang']; ?>
                                <?php $date2 = 'date_' . $lang['lang']; ?>
                                <!-- Dashboard Tab Pane 1-->
                            <div class="tab-pane fade @if ($index == 0) show active @endif"
                                 id="multi_content_{{ $lang['lang'] }}" role="tabpanel"
                                 aria-labelledby="multi_content_{{ $lang['lang'] }}-pill">
                                <div class="container p-0">
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-group col-12">
                                                <label class="small mb-1" for="name_{{ $lang['lang'] }}">Name</label>
                                                <input class="form-control" id="name_{{ $lang['lang'] }}" name="name_{{ $lang['lang'] }}" type="text" value="{{ $item->$name }}" placeholder="name"/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-12">
                                                <label class="small mb-1" for="address_{{ $lang['lang'] }}">Address</label>
                                                <input placeholder="address" class="form-control textarea" id="address_{{ $lang['lang'] }}" name="address_{{ $lang['lang'] }}" value="{{ $item->$address }}" rows="12">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-12">
                                                <label class="small mb-1" for="date_{{ $lang['lang'] }}">Open at</label>
                                                <input placeholder="date" class="form-control" id="date_{{ $lang['lang'] }}" name="date_{{ $lang['lang'] }}" value="{{$item->$date}}" rows="12">
                                            </div>
                                            <div class="form-group col-12">
                                                <label class="small mb-1" for="date2_{{ $lang['lang'] }}">Open at weekend</label>
                                                <input placeholder="date"  class="form-control" id="date2_{{ $lang['lang'] }}" name="date2_{{ $lang['lang'] }}" value="{{ $item->$date2 }}"  rows="12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tab content end -->
            </div>
        </div>
    </div>
</form>
<div class="modal-buttons">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" onclick="save()" id="saveItemBtn" class="btn btn-success">Save</button>
</div>

<script>
    function save() {
        tinyMCE.triggerSave();
        Loading.add($('#saveItemBtn'));
        var data = $('#save-item-form').serializeFormJSON();
        console.log(data);

        $.ajax({
            type: "POST",
            url: "{{ route('adminAddressSave') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    if (response.messages) {
                        toastr['error'](response.message, 'Error');
                    } else {
                        toastr['error'](response.message, 'Error');
                    }
                }
                if (response.status == 1) {
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
    $(document).ready(function() {
        var upload = new SUpload;
        upload.init({
            uploadContainer: 'cover',
            token: "<?php echo csrf_token(); ?>",
            imageIdReturnEl: ".cover"
        });

        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-dialog").length) {
                e.stopImmediatePropagation();
            }
        });
    });
</script>
