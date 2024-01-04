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
                            <img class="thumbnail" src="@if ($item->img) {{ asset('images/backendSmall/'.$item->img) }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif" />
                            <input type="hidden" name="img" class="cover" value="{{ $item->id }}" />
                        </div>
                        <div class="image-action @if ($item->img) fileExist @else fileNotExist @endif">
                            <div>
                                <span id="recommended_img_size"></span>
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
            <div class="card mb-4">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label class="small mb-1" for="published">Status</label>
                            <select class="form-select form-control" name="published">
                                <option @if($item->published == 1) selected @endif value="1">Published</option>
                                <option @if($item->published == 0) selected @endif value="0">Unpublished</option>
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label class="small mb-1" for="type">Type</label>
                            <select class="form-select form-control"  id="deal_type" name="type">
                                <option value="0">- Select type -</option>
                                <option data-image-size="Image not need" @if($item->type == 1) selected @endif value="1">Top header</option>
                                <option data-image-size="Size: 1198x138" @if($item->type == 2) selected @endif value="2">Home middel</option>
                                <option data-image-size="Size: 375x586" @if($item->type == 3) selected @endif value="3">Sidebar small</option>
                                <option data-image-size="Size: 375x980" @if($item->type == 4) selected @endif value="4">Sidebar big</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label class="small mb-1" for="type">Promo</label>
                            <select class="form-select form-control" name="promo_id">
                                <option value="0">- Select promo -</option>
                                @if($promos && count($promos) > 0)
                                @foreach($promos as $promo)
                                    <option @if($item->promo_id == $promo->id) selected @endif value="{{ $promo->id }}">{{ $promo->title }} ({{$promo->code}})</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
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
                                    <textarea  class="form-control textarea" id="descripition" name="description" rows="12">{{ $item->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

        $.ajax({
            type: "POST",
            url: "{{ route('aDealSave') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.errors, 'Error');
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
        var recommendedSizeSpan = $('#recommended_img_size');
        function updateRecommendationAndButtonState() {
            var selectedOption = $('#deal_type option:selected');
            var imageSize = selectedOption.data('image-size');
            
            // Update recommended image size
            recommendedSizeSpan.text(imageSize);
        }
        $('#deal_type').change(updateRecommendationAndButtonState);
        updateRecommendationAndButtonState();

        // initTinymce();
        // console.log('asdasd')
        var upload = new SUpload;
        upload.init({
            uploadContainer: 'cover',
            token: "<?php echo csrf_token(); ?>",
            imageIdReturnEl: ".cover",
            deal: "{{ $item->id }}"
        });

        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-dialog").length) {
                e.stopImmediatePropagation();
            }
        });
    });
</script>