<script type="text/javascript">
    if (typeof(itemPopup) != "undefined") {
        $(itemPopup).one("loaded", function(e) {
            initTinymce();
            Loading.remove($('#add_item'));
        });
    }
</script>
<style>
.main-tab.fade:not(.show) {
    opacity: 0;
    display: none;
}
</style>
@include('admin.blocks.uploader')
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
                                <span>Size: 1000x667</span>
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
                                <label class="small mb-1" for="slug">Slug</label>
                                <input class="form-control" id="slug" name="slug" type="text"
                                    placeholder="Slug" value="{{ $item->slug }}" />
                        </div>
                        <div class="form-group col-6">
                            <label class="small mb-1" for="published">Status</label>
                            <select class="form-select form-control" name="published">
                            <option @if($item->published == 1) selected @endif value="1">Published</option>
                            <option @if($item->published == 0) selected @endif value="0">Unpublished</option>
                        </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small mb-1" for="publishedDate">Published Date</label>
                            <input class="form-control" id="publishedDate" name="publishedDate"
                                type="text" value="{{ $item->publishedDate }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <div class="small mb-1" style="visibility: hidden;">Placeholder</div>
                            <input name="featured" value="1" type="checkbox" id="featured" {{$item->featured == 1 ? 'checked' : ''}} >
                            <label for="featured">Featured</label>
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
                                <div class="form-group col-12">
                                    <label class="small mb-1" for="descripition">Body</label>
                                    <textarea  class="form-control textarea wysihtml5" id="body" name="body" rows="12">{{ $item->body }}</textarea>
                                </div>
                            </div>
                            <div>
                                <input class="inheritMeta" name="inheritMeta" @if($item->inheritMeta == 1) checked="checked" @endif id="inheritMeta" type="checkbox">
                                <label for="inheritMeta">Inherit Meta</label>
                            </div>
                            <div class="meta_content" @if($item->inheritMeta == 1) style="display:none" @endif>
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label class="small mb-1" for="meta_title">Meta title</label>
                                        <input class="form-control" id="meta_title" name="meta_title" type="text" value="{{ $item->meta_title }}" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label class="small mb-1" for="descripition">Meta description</label>
                                        <textarea  class="form-control textarea" id="meta_descripition" name="meta_description" rows="12">{{ $item->meta_description }}</textarea>
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
            url: "{{ route('adminBlogSave') }}",
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
        
        $(document).on("change", ".inheritMeta", function (event) {
            const checked = $(this).is(":checked")
            $(".meta_content").css({display: checked ? "none" : "block"});
        });

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
