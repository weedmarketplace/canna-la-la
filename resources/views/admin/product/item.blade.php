<script type="text/javascript">
    if (typeof(itemPopup) != "undefined") {
        $(itemPopup).one("loaded", function(e) {
            initTinymce();
            Loading.remove($('#add_item'));
        });
    }
</script>
<link href="{!! asset('backend/plugins/dropzone/css/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script src="{!! asset('backend/plugins/dropzone/dropzone.js') !!}" type="text/javascript"></script>
<script src="{!! asset('backend/js/scripts/gallery.js?8') !!}" type="text/javascript"></script>
<div id="preview-template" style="display:none">
	<div class="dz-preview dz-file-preview">
		<div class="dz-details">
			<div class="dz-filename"><span data-dz-name></span></div>
			<!-- <div class="dz-size" data-dz-size></div> -->
			<img data-dz-thumbnail />
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
		<div class="dz-success-mark"><span>✔</span></div>
		<div class="dz-error-mark"><span>✘</span></div>
		<div class="dz-error-message"><span data-dz-errormessage></span></div>
	</div>
</div>
<style>
.main-tab.fade:not(.show) {
    opacity: 0;
    display: none;
}
</style>
@include('admin.blocks.uploader')
<!-- Main page content-->
<div class="row">
    <div class="col-xxl-12">
        <!-- Tabbed dashboard card example-->
        <div class="card mb-4">
            <div class="card-header border-bottom">
                <!-- Dashboard card navigation-->
                <ul class="nav nav-tabs card-header-tabs main-tabs" id="dashboardNav" role="tablist">
                    <li class="nav-item mr-1"><a class="nav-link active" id="overview-pill" href="#overview" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Overview</a></li>
                    <li class="nav-item"><a class="nav-link" id="attributes-pill" href="#attributes" data-toggle="tab" role="tab" aria-controls="attributes" aria-selected="false">Attributes & Pricing</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" id="pricing-pill" href="#pricing" data-toggle="tab" role="tab" aria-controls="pricing" aria-selected="false">Pricing</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" id="log-pill" href="#log" data-toggle="tab" role="tab" aria-controls="log" aria-selected="false">Log</a></li> -->
                    <li class="nav-item"><a class="nav-link" id="gallery-pill" href="#gallery" data-toggle="tab" role="tab" aria-controls="gallery" aria-selected="false">Gallery</a></li>
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
                                <input type="hidden" name="id" id="id" value="{{$item->id}}" />
                                <div class="col-lg-4 mb-4" style="display: inline-table;">
                                    <div class="card h-100 border-left-lg border-left-primary">
                                        <div class="card-header">Cover</div>
                                        <div class="card-body">
                                            <div class="image-upload-container text-center" id="cover">
                                                <div class="image-part">
                                                    <img class="thumbnail" src="@if ($item->img) {{ asset('images/backendSmall/'.$item->img) }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif"/>
                                                    <input type="hidden" name="cover" class="cover" value="@if ($item->img) {{ $item->img }} @endif" />
                                                </div>
                                                <div class="image-action @if ($item->img) fileExist @else fileNotExist @endif">
                                                    <!-- <div>
                                                        <span >size: (658x795) </span>
                                                    </div> -->
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
                                    <div class="card h-100 border-left-lg border-left-primary mt-md-2">
                                        <div class="card-header">Features</div>
                                        <div class="card-body">
                                            <div class="form-group" >
                                                @foreach($features as $feature)
                                                    <?php $checked = $item->$feature == 1 ? 'checked' : ''; ?>
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" name="{{$feature}}" <?= $checked ?>  value="1" id="{{$feature}}" type="checkbox">
                                                        <label class="custom-control-label" for="{{$feature}}">{{rplUC($feature)}}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <!-- Account details card-->
                                    <div class="card mb-4">
                                        <div class="card-header border-bottom">Main</div>
                                        <div class="card-body">
                                            <?php /*
                                            <div class="form-group">
                                                <label class="small mb-1" for="url">Url</label>
                                                <input class="form-control" id="url" name="url" type="text" value="{{$item->url}}" />
                                            </div>
                                            */?>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <div class="small">Status</div>
                                                        <select class="form-select form-control" name="status" aria-label="">
                                                        <option @if($item->public == 1) selected @endif value="1">Published</option>
                                                        <option @if($item->public == 0) selected @endif value="0">Unpublished</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header border-bottom">Category</div>
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <div id="categoriesContainer">
                                                        <!-- Top-level categories -->
                                                        <div class="category-level main col-md-4" id="categoryLevel0">
                                                        {!! $collections !!}
                                                        </div>
                                                        <!-- Subsequent category levels are initially hidden -->
                                                        <div class="category-level main col-md-4" id="categoryLevel1" ></div>
                                                        <div class="category-level main col-md-4" id="categoryLevel2"></div>
                                                        <!-- Add more levels if needed -->
                                                    </div>
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
                        </div>
                    </div>
                    <div class="tab-pane fade main-tab" id="attributes" role="tabpanel"  aria-labelledby="attributes-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6" style="display: inline-table;">
                                    <div class="card mb-6">
                                        <div class="card-header border-bottom">Cannabioids</div>
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label class="small mb-1" for="thc">THC %</label>
                                                    <input class="form-control" id="thc" name="thc" type="text" value="{{$item->thc}}" />
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="small mb-1" for="cbd">CBD %</label>
                                                    <input class="form-control" id="cbd" name="cbd" type="text" value="{{$item->cbd}}" />
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label class="small mb-1" for="thc_milligrams">THC milligrams</label>
                                                    <input class="form-control" id="thc_milligrams" name="thc_milligrams" type="text" value="{{$item->thc_milligrams}}" />
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="small mb-1" for="cbd_milligrams">CBD milligrams</label>
                                                    <input class="form-control" id="cbd_milligrams" name="cbd_milligrams" type="text" value="{{$item->cbd_milligrams}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6" style="display: inline-table;">
                                    <div class="card mb-6">
                                        <div class="card-header border-bottom">Discovery</div>
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <div class="small">Strain</div>
                                                    <select class="form-select form-control" name="strain" aria-label="">
                                                        <option  @if(!$item->strain) selected @endif value="-1">- Select strain {{$item->strain}} -</option>
                                                        @foreach($strains as $key => $strain)
                                                            <option @if($item->strain && $item->strain == $key) selected @endif value="{{$key}}">{{$strain}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="small">Genetics</div>
                                                    <select class="form-select form-control" name="genetic" aria-label="">
                                                        <option @if(!$item->genetic) selected @endif value="-1">- Select genetic -</option>
                                                        @foreach($genetics as $key => $genetic)
                                                            <option @if($item->genetic && $item->genetic == $key) selected @endif value="{{$key}}">{{$genetic}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-4" style="display: inline-table;">
                                    <div class="card mb-6">
                                        <div class="card-header border-bottom">Sale pricing</div>
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label class="small mb-1" for="discount">Percent off %</label>
                                                    <input class="form-control" id="discount" name="discount" type="text" value="{{$item->discount}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-12" style="display: inline-table;">
                                    <div class="card mb-6">
                                        <div class="card-header border-bottom">Pricing</div>
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="form-group">
                                                    <div class="custom-control custom-radio mr-2" style="display: inline-block;">
                                                        <input class="custom-control-input"  id="select_pricing_type_by_weight" value="by_weight" type="radio" name="pricing_type" @if($item->pricing_type == 'by_weight' || $item->pricing_type == null ) checked="" @endif >
                                                        <label class="custom-control-label" for="select_pricing_type_by_weight">Price by weight</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="display: inline-block;">
                                                        <input class="custom-control-input" id="select_pricing_type_by_unit" value="by_unit" type="radio" name="pricing_type" @if($item->pricing_type == 'by_unit') checked="" @endif>
                                                        <label class="custom-control-label" for="select_pricing_type_by_unit">Price by unit</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row" id="pricing_by_weight" @if($item->pricing_type == 'by_unit') style="display: none;" @endif>
                                                <div class="form-group col-md-3">
                                                    <label class="small mb-1" style="display: block;">Weight</label>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="small mb-1" for="unit_price">Price</label>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="small mb-1" for="unit_cost">Cost</label>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="small mb-1" for="unit_count">Count</label>
                                                </div>
                                                @foreach($pricing as $key =>  $price)
                                                    <div class="form-group col-md-3">
                                                        <label class="small mb-1">{{$price}}</label>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input class="form-control" name="weight_price[{{$key}}]" type="text" value="@if(isset($fillPricing[$key])){{$fillPricing[$key]['price']}}@endif"/>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input class="form-control" name="weight_cost[{{$key}}]" type="text" value="@if(isset($fillPricing[$key])){{$fillPricing[$key]['cost']}}@endif"/>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input class="form-control" name="weight_count[{{$key}}]" type="text" value="@if(isset($fillPricing[$key])){{$fillPricing[$key]['qty']}}@endif"/>
                                                    </div>
                                                @endforeach
                                                @if($customVariations && count($customVariations) > 0)
                                                    <div id="existingVariations">
                                                    @foreach($customVariations as $variation)
                                                        <div class="form-row custom-variation">
                                                            <div class="form-group col-md-1">
                                                                <input class="form-control" name="variations[num][]" type="text" placeholder="Num" value="{{ $variation->num }}">
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <select class="form-select form-control" name="variations[unit][]">
                                                                    @foreach($measurement as $key => $measure)
                                                                        <option value="{{ $key }}" {{ $variation->unit == $key ? 'selected' : '' }}>{{ $measure }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <input class="form-control" name="variations[price][]" type="text" placeholder="Price" value="{{ $variation->price }}">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <input class="form-control" name="variations[cost][]" type="text" placeholder="Cost" value="{{ $variation->cost }}">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <input class="form-control" name="variations[count][]" type="text" placeholder="Count" value="{{ $variation->qty }}">
                                                                <button type="button" class="btn remove-variation" data-variation-id="{{ $variation->id }}">
                                                                    <span><i class="fa fa-times"></i></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    </div>
                                                @endif
                                                <div id="customVariationsContainer"></div>
                                                    <div class="form-group col-md-12">
                                                    <button type="button" class="btn btn-primary" id="addVariation">Add Custom Variation</button>
                                                </div>
                                            </div>
                                            <div class="form-row" id="pricing_by_unit" @if($item->pricing_type == 'by_weight' || $item->pricing_type == null ) style="display: none;" @endif>
                                                <div class="form-group col-md-3">
                                                    <label class="small mb-1" style="display: block;">Weight</label>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="small mb-1" for="unit_price">Price</label>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="small mb-1" for="unit_cost">Cost</label>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="small mb-1" for="unit_count">Count</label>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="small mb-1">1 Unit</label>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" id="unit_price" name="unit_price" type="text" value="{{$pricingByUnit->price}}"/>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" id="unit_cost" name="unit_cost" type="text" value="{{$pricingByUnit->cost}}"/>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" id="unit_count" name="unit_count" type="text" value="{{$pricingByUnit->qty}}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane main-tab fade" id="gallery" role="tabpanel"  aria-labelledby="gallery-tab">
                        <div class="container">
                            <div class="card">
                                <div class="card-header">Size: (380x450)</div>
                                <div class="card-body">
                                    <div class="clearfix"></div>
                                    <div id="gallery-container"></div>
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
<style>
.remove-variation{
    position: absolute;
    right: -22px;
    top: 6px;
    width: 2px;
    height: 2px;
}
.custom-variation{
    position: relative;
}
</style>
<div id="variationTemplate" style="display:none;">
    <div class="form-row custom-variation">
        <div class="form-group col-md-1">
            <input class="form-control" name="variations[num][]" type="text" placeholder="Num"/>
        </div>
        <div class="form-group col-md-2">
            <select class="form-select form-control" name="variations[unit][]" aria-label="">
                @foreach($measurement as $key => $measure)
                    <option value="{{$key}}">{{$measure}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <input class="form-control" name="variations[price][]" type="text" placeholder="Price"/>
        </div>
        <div class="form-group col-md-3">
            <input class="form-control" name="variations[cost][]" type="text" placeholder="Cost"/>
        </div>
        <div class="form-group col-md-3">
            <input class="form-control" name="variations[count][]" type="text" placeholder="Count"/>
        </div>
        <button type="button" style="position: absolute;" class="btn remove-variation">
            <span><i class="fa fa-times"></i></span>
        </button>
    </div>
</div>
<script>
    function initializeCategorySelection() 
    {
        const categoryLevel0 = $('#categoryLevel0.main');
        const categoryLevel1 = $('#categoryLevel1.main');
        const categoryLevel2 = $('#categoryLevel2.main');

        function handleCategoryChange(selectedCategoryId, targetLevel, nextLevel = null) {
            updateSubcategories(selectedCategoryId, targetLevel, nextLevel);
        }

        categoryLevel0.on('change', 'input[type="radio"]', function() {
            handleCategoryChange($(this).val(), categoryLevel1, categoryLevel2);
        });

        categoryLevel1.on('change', 'input[type="radio"]', function() {
            handleCategoryChange($(this).val(), categoryLevel2);
        });

        // Handle preselected categories
        function initializePreselectedCategories() {
            const selectedLevel0 = categoryLevel0.find('input[type="radio"]:checked').val();
            if (selectedLevel0) {
                handleCategoryChange(selectedLevel0, categoryLevel1, categoryLevel2);
                // categoryLevel1.find('input[type="radio"]:checked').trigger('change');
            }

            const selectedLevel1 = categoryLevel1.find('input[type="radio"]:checked').val();
            if (selectedLevel1) {
                handleCategoryChange(selectedLevel1, categoryLevel2);
                const el = categoryLevel2.find('input[type="radio"]');
                el.each(function() {
                    if($(this).attr('checked')){
                        $(this).prop('checked', true);
                    }
                });
            }
        }

        function updateRadioButtonsState(targetLevel, selectedCategoryId) {
            targetLevel.find('input[type="radio"]').each(function() {
                $(this).prop('checked', $(this).val() === selectedCategoryId);
            });
        }

        function updateSubcategories(selectedCategoryId, targetLevel, nextLevel = null) {
            const subCategoryDiv = $('#subCategory_' + selectedCategoryId);

            targetLevel.empty();
            if (subCategoryDiv.length) {
                const innerCategoryLevelDiv = subCategoryDiv.children('.category-level').first();
                innerCategoryLevelDiv.children().each(function() {
                    const clonedChild = $(this).clone();
                    clonedChild.css('display', 'block');
                    targetLevel.append(clonedChild);
                });

                targetLevel.css('display', 'block');
            } else {
                targetLevel.css('display', 'none');
            }

            if (nextLevel) {
                nextLevel.empty();
                nextLevel.css('display', 'none');
            }
        }
        initializePreselectedCategories();
    }
    document.getElementById('addVariation').addEventListener('click', function() {
        // Clone the template
        var newVariation = document.getElementById('variationTemplate').cloneNode(true);
        newVariation.style.display = 'block'; // Make it visible
        newVariation.id = ''; // Remove the id as it's no longer a template

        // Append the cloned template to the container
        document.getElementById('customVariationsContainer').appendChild(newVariation);
    });
    document.getElementById('customVariationsContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-variation')) {
            // Remove the .custom-variation parent of the delete button
            e.target.closest('.custom-variation').remove();
        }
    });
    $(document).off('click', '#existingVariations .remove-variation').on('click', '#existingVariations .remove-variation', function() {
        var variationId = $(this).data('variation-id');
        var parentDiv = $(this).closest('.custom-variation');

        $.ajax({
            url: "{{ route('deleteVariation') }}",
            type: 'POST',
            data: {
                id: variationId,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    parentDiv.remove();
                } else {
                    alert('Could not delete the variation. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
    $(document).ready(function() {
        initializeCategorySelection();
        feather.replace();
        
        $(document).on("change", ".inheritMeta", function (event) {
            const checked = $(this).is(":checked")
            $(".meta_content").css({display: checked ? "none" : "block"});
        });

        $('#select_pricing_type_by_weight').on('change',function (){
            if( $('#select_pricing_type_by_weight').is(':checked') ){
                $('#pricing_by_unit').hide()
                $('#pricing_by_weight').show()
            }
            else{
                $('#pricing_by_weight').hide()
                $('#pricing_by_unit').show()
            }
        });
        
        $('#select_pricing_type_by_unit').on('change',function (){
            if( $('#select_pricing_type_by_unit').is(':checked') ){
                $('#pricing_by_weight').hide()
                $('#pricing_by_unit').show()
            }
            else{
                $('#pricing_by_unit').hide()
                $('#pricing_by_weight').show()
            }
        });

        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-dialog").length) {
                e.stopImmediatePropagation();
            }
        });
        
        var upload = new SUpload;
    	upload.init({
    		uploadContainer: 'cover',
    		token: "<?php echo csrf_token(); ?>",
    		imageIdReturnEl: ".cover",
    		cover: "<?php echo $item->id; ?>"
    	});

        var gallery = new Gallery;
        gallery.init({
			gallery_id:'{{$item->gallery_id}}',
			_token: '{{ csrf_token() }}',
			container: '#gallery-container',
		})

		window.gallery = gallery;
        @if($hasGallery)
            gallery.load({{$item->gallery_id}})
        @else
            gallery.load()
        @endif
        feather.replace();

        
    });
    function save() {
        tinyMCE.triggerSave()
        Loading.add($('#saveBtn'));
        var data = $('#save-form').serializeFormJSON();
        
        $.ajax({
            type: "POST",
            url: "{{ route('productSave') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.errors, 'Error');
                }
                if (response.status == 1) {
                    toastr['success'](response.message, 'Success');
                    window.datatable.ajax.reload(null, false);
                    itemPopup.close();
                }
                Loading.remove($('#saveBtn'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown, 'Error');
                Loading.remove($('#saveBtn'));
            }
        });
    }
    
</script>
