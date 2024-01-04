<script type="text/javascript">
    if (typeof(itemPopup) != "undefined") {
        $(itemPopup).one("loaded", function(e) {
            initTinymce();
        });
    }
</script>
<form id="save-item-form" method="post">
    @csrf
    <input type="hidden" class="hidden_id" name="id" value="{{ $item->id }}" />
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
            <div class="card-header">Details</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-12">
                        <label class="small mb-1" for="title">Title</label>
                        <input class="form-control" id="title" name="title" type="text" placeholder="Title" value="{{ $item->title }}" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="body">Text</label>
                    <textarea class="form-control wysihtml5" id="body" name="body" rows="12">{{ $item->body }}</textarea>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal-buttons">
    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" onclick="save()"  id="saveItemBtn" class="btn btn-success" >Save</button>
</div>
<script>
function save() {
    tinyMCE.triggerSave()
    Loading.add($('#saveItemBtn'));
    var data = $('#save-item-form').serializeFormJSON();
    console.log(data)
    $.ajax({
        type: "POST",
        url: "{{ route('aArticleSave') }}",
        data: data,
        dataType: 'json',
        success: function(response) {
            if (response.status == 0) {
                toastr['error'](response.message, 'Error');
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
    initTinymce();
    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".tox-dialog").length) {
            e.stopImmediatePropagation();
        }
    });
});
</script>