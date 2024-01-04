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
    .dropdown {
        position: relative;
        display: inline-block;
        cursor: pointer;
        width: 200px;
    }

    .dropdown .selected {
        background: #ddd;
        padding: 10px;
        border: 1px solid #ccc;
    }

    .dropdown .selected img {
        height: 15px;
        width: 20px; /* adjust as needed */
    }

    .dropdown .dropdown-options {
        display: none;
        position: absolute;
        background: #fff;
        width: 100%;
        max-height: 300px; /* sets maximum height */
        overflow-y: auto; /* enables vertical scrolling when content exceeds max-height */
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        z-index: 9999; /* places dropdown options above other content */
    }
    .dropdown .dropdown-options .dropdown-option {
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }

    .dropdown .dropdown-options .dropdown-option img {
        height: 20px;
        margin-right: 10px;
    }

    .dropdown .dropdown-options .dropdown-option:last-child {
        border-bottom: none;
    }
    .dropdown-option .option-content {
        display: flex; /* layout the image and text horizontally */
        align-items: center; /* vertically center the image and text */
    }

    .dropdown-option .option-content img {
        height: 15px;
        width: 20px; /* adjust as needed */
        margin-right: 10px; 
        flex-shrink: 0;
    }

    .dropdown-option .option-content span {
        overflow: hidden; /* prevent the text from overflowing the container */
        text-overflow: ellipsis; /* add an ellipsis (...) when the text overflows */
        white-space: nowrap; /* prevent the text from wrapping onto multiple lines */
    }
</style>
<form id="save-item-form" method="post">
    <div class="row">
        <input type="hidden" class="hidden_id" name="id" value="{{ $item->id }}" />
        <input type="hidden" name="icon" id="icon">
        @csrf
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">Collection</div>
                <div class="card-body ">
                    <div class="image-upload-container" id="cover">
                        @foreach($collections as $collection)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" name="collection" value="{{ $collection->id }}" id="{{$collection->title_en}}" type="checkbox"
                                       @if($collection_countries->where('collection_id', $collection->id)->where('country_id', $item->id)->count() > 0)checked @endif>
                                <label class="custom-control-label" for="{{$collection->title_en}}">{{rplUC($collection->title_en)}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group ">
                            <div class="small">Icon</div>
                            <div class="dropdown">
                                <div class="selected">
                                    <img src="{{$item->icon ? asset('assets/flags_svg/' . $item->icon) : ''}}">
                                    <span>{{$item->icon ? $item->icon : "Select"}}</span>
                                </div>
                                <div class="dropdown-options">
                                    @foreach($flags as $key => $flag)
                                        <div class="dropdown-option">
                                            <div class="option-content">
                                                <img src="{{ $flag }}" alt="{{ $key }}">
                                                <span>{{ $key }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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
                                <?php $title = 'title_' . $lang['lang']; ?>
                            <div class="tab-pane fade @if ($index == 0) show active @endif"
                                 id="multi_content_{{ $lang['lang'] }}" role="tabpanel"
                                 aria-labelledby="multi_content_{{ $lang['lang'] }}-pill">
                                <div class="container p-0">
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-group col-12">
                                                <label class="small mb-1" for="title_{{ $lang['lang'] }}">Title</label>
                                                <input class="form-control"  id="title_{{ $lang['lang'] }}" name="title_{{ $lang['lang'] }}" type="text" value="{{ $item->$title }}" placeholder="title"/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-12">
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
    $(".dropdown").click(function(){
        $(this).children(".dropdown-options").toggle();
    });

    $(".dropdown-option").click(function(e){
        e.stopPropagation();
        var selectedText = $(this).text();
        var selectedImgSrc = $(this).find('img').attr('src');
        var selectedImgAlt = $(this).find('img').attr('alt');
        $(this).closest(".dropdown").children(".selected").html('<img src="'+selectedImgSrc+'" alt="'+selectedImgAlt+'"><span>'+selectedText+'</span>');
        $(this).closest(".dropdown-options").hide();

        // update the hidden input's value
        $("#icon").val(selectedText);
    });

    function save() {
        tinyMCE.triggerSave();
        Loading.add($('#saveItemBtn'));
        var data = $('#save-item-form').serializeFormJSON();
        console.log(data);

        $.ajax({
            type: "POST",
            url: "{{ route('adminCountrySave') }}",
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
        // initTinymce();
        // console.log('asdasd')
        var upload = new SUpload;
        upload.init({
            uploadContainer: 'cover',
            token: "<?php echo csrf_token(); ?>",
            imageIdReturnEl: ".cover",
            blog: "{{ $item->id }}"
        });

        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-dialog").length) {
                e.stopImmediatePropagation();
            }
        });

        $('input[name="publishedDate"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });
</script>
