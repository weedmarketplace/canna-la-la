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
                            <img class="thumbnail"
                                 src="@if ($item->image) {{ $item->image->path }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif" />
                            <input   type="hidden" name="image_id" class="cover"
                                   value="@if ($item->image) {{ $item->image->id }} @endif" />
                        </div>
                        <div class="image-action @if ($item->image) fileExist @else fileNotExist @endif">
                            <div>
                                <span >size: (1920 x 637) </span>
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
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <input @if($item->linkType == 0) checked @endif id="internal" type="radio" value="0"  name="linkType">
                                <label for="internal">Internal</label>
                                <input @if($item->linkType == 1) checked @endif id="external"  type="radio" value="1"  name="linkType">
                                <label for="external">External</label>
                            </div>
                            <div class="form-group col-6">
                                <select class="form-select form-control" name="status" aria-label="">
                                    <option @if($item->status == 1) selected @endif value="1">Published</option>
                                    <option @if($item->status == 0) selected @endif value="0">Unpublished</option>
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label class="small mb-1" for="link">Link</label>
                                <input class="form-control" value="{{ $item->link }}" id="link"  name="link" type="text" placeholder="Link"/>
                            </div>
                            <div class="form-group col-12">
                                <label class="small mb-1"  for="title">Title</label>
                                <input class="form-control" value="{{ $item->title }}" id="title"  name="title" type="text" placeholder="Title"/>
                            </div>
                            <div class="form-group col-12">
                                <label class="small mb-1"  for="button_title">Button</label>
                                <input class="form-control" value="{{ $item->button_title }}" id="button_title" name="button_title" type="text" placeholder="Button title"/>
                            </div>
                            <div class="form-group col-12">
                                <label class="small mb-1" for="descripition">Description</label>
                                <textarea  class="form-control textarea" id="descripition" name="description" rows="12">{{ $item->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <!-- Tab content end -->
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
        console.log(data);

        $.ajax({
            type: "POST",
            url: "{{ route('adminSliderSave') }}",
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

        var upload = new SUpload;
        upload.init({
            uploadContainer: 'cover',
            token: "<?php echo csrf_token(); ?>",
            imageIdReturnEl: ".cover",
            slider: "{{ $item->id }}"
        });

        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-dialog").length) {
                e.stopImmediatePropagation();
            }
        });
    });
</script>
