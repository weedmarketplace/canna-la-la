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
                                        <div class="card  border-left-lg border-left-primary">
                                            <div class="card-header">Cover</div>
                                            <div class="card-body">
                                                <div class="image-upload-container text-center" id="cover">
                                                    <div class="image-part">
                                                        <img class="thumbnail" src="@if ($item->image) {{ $item->imagePath }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif"/>
                                                        <input type="hidden" name="img" class="cover" value="{{ $item->id }}" />
                                                    </div>
                                                    <div class="image-action @if ($item->image) fileExist @else fileNotExist @endif">
                                                        <div>
                                                            <span>Only SVG</span>
                                                        </div>
                                                        <div class="img-not-exist">
                                                            <span id="uploadBtn" class="btn btn-success">Select image </span>
                                                        </div>
                                                        <div class="img-exist">
                                                            <span class="btn btn-danger remove-image">Remove</span>
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
                                                <div class="form-group">
                                                    <label class="small mb-1" for="title">Slug</label>
                                                    <input class="form-control" name="slug" type="text" placeholder="Slug" value="{{ $item->slug }}" />
                                                </div>
                                                <div class="form-group">
                                                    <input name="featured" value="1" type="checkbox" id="featured" {{$item->featured == 1 ? 'checked' : ''}} >
                                                    <label for="featured">Featured</label>
                                                </div>
                                                <div class="form-group col-md-6 p-0">
                                                    <span class="el_item">Status:
                                                        <select class="form-select form-control" name="status" aria-label="Default select example">
                                                            <option @if($item->status == 1) selected @endif value="1">Published</option>
                                                            <option @if($item->status == 0) selected @endif value="0">Unublished</option>
                                                        </select>
                                                    </span>
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
function save(){
    Loading.add($('#saveItemBtn'));
    var data = $('#save-form').serializeFormJSON();

    $.ajax({
        type: "POST",
        url: "{{route('adminCollectionSave')}}",
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
$(document).ready(function(){
        $(document).on("change", ".inheritMeta", function (event) {
            const checked = $(this).is(":checked")
            $(".meta_content").css({display: checked ? "none" : "block"});
        });
        var upload = new SUpload;
        upload.init({
            uploadContainer: 'cover',
            token: "<?php echo csrf_token(); ?>",
            imageIdReturnEl: ".cover",
            collection: "{{ $item->id }}",
        });
        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-dialog").length) {
                e.stopImmediatePropagation();
            }
        });
});
</script>
