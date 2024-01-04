@extends('admin.layouts.app')
@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="gift"></i></div>
                        Products
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary btn-sm" id="add_item" type="button">Add</button>
                <button class="btn btn-danger btn-sm" id="remove_item" type="button">Remove</button>
                <!-- <button class="btn btn-primary btn-sm float-right" style="margin-right: 8px;" id="sync" type="button">Sync 1C</button> -->
                <!-- <a class="btn btn-danger btn-sm float-right" style="margin-right: 8px;" href="{{ route('reportsIndex') }}" type="button"> Reports</a> -->
                <!-- <button class="btn btn-danger btn-sm add_new_attribute" type="button">Attribute</button> -->
            </div>
            <div class="card-body">
                <div class="col-12 col-xl-auto float-left">
                    <div class="d-flex">
                        <div class="custom-control custom-switch mt-n2">
                            <input class="custom-control-input" id="on_off" type="checkbox" checked >
                            <label class="custom-control-label" for="on_off"></label>
                        </div>
                        <div class="small text-muted">InStock</div>
                    </div>
                </div>
                @if($collections)
                <div class="form-group col-md-2 float-right ml-2 p-0">
                    <div class="small text-muted">Category</div>
                    <select class="form-control" name="filter_category" id="filter_category" >
                        <option value='-1'>-- All--</option>
                        <?= $collections; ?>
                    </select>
                </div>
                @endif
                <div class="form-group col-md-2 float-right">
                    <div class="small text-muted">Status</div>
                    <select class="form-control" name="filter_status" id="filter_status">
                        <option value=''>-- All--</option>
                        <option value='1'>Published</option>
                        <option value='0'>Unpublished</option>
                        <option value='2'>Removed</option>
                    </select>
                </div>
                <div class="table-responsive">
                        <table class="table table-bordered table-hover " id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ordering</th>
                                <!-- <th>Code</th> -->
                                <th>Title</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ordering</th>
                                <!-- <th>Code</th> -->
                                <th>Title</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                        </tfoot>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Main page content-->
</main>
@push('css')
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
@endpush
@push('script')
    @include('admin.blocks.ui')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="{!! asset('backend/plugins/tinymce/tinymce.min.js') !!}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('body').on('hide.bs.modal', function (e) {
                setTimeout(function(){
                    if($('.panda-popup-modal').length > 0)
                    {
                        $('body').addClass('modal-open')
                    }else{
                        $('.modal-backdrop').remove();
                    }
                }, 500);
            });

            $('#dataTable').sortable({
                items: "tbody tr",
                opacity: 0.8,
                coneHelperSize: true,
                tolerance: "pointer",
                helper: "clone",
                tolerance: "pointer",
                revert: 250, // animation in milliseconds
                update: function(event, ui) {
                    var ids = new Array();
                    $('tbody tr', '#dataTable').each(function(index) {
                        ids.push($(this).attr('id'));
                    });
                    category = $('#filter_category').val();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('productsSort') }}",
                        dataType: 'JSON',
                        data:{_token: "<?php echo csrf_token(); ?>", ids:ids, category:category},
                    });
                },
            });
            $( "#dataTable" ).sortable( "disable" );

            const capitalize = (s) => {
                if (typeof s !== 'string') return ''
                return s.charAt(0).toUpperCase() + s.slice(1)
            }

            var dataTable =  $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                'searching': true,
                "ajax": {
                    "url": "{{ route('productData') }}",
                    "data": function(data){
                        data['sort_field'] = data.columns[data.order[0].column].name;
                        data['sort_dir'] =  data.order[0].dir;
                        data['search'] = data.search.value;

                        delete data.columns;
                        delete data.order;
                        // delete data.search;

                        var filter_status = $('#filter_status').val();
                        data.filter_status = filter_status;

                        data.filter_category = $('#filter_category').val();

                        if( $('#on_off').is(':checked') ){
                            data.inStock = 1;
                        }else{
                            data.inStock = 0;
                        }
                    }
                },
                "fnDrawCallback": function( oSettings ) {
                    feather.replace();
                    $('[data-toggle="popover"]').popover();
                },
                "columns": [
                    { "data": 'ordering', 'name': 'ordering',"orderable": true},
                    { "data": 'title', 'name': 'title',"orderable": true},
                    {
                        "data": "pricing_type",
                        "name": 'pricing_type',
                        "orderable": true,
                        "render": function(data, type, row) {
                            let priceContent = '';
                            if (row.pricing_type === 'by_weight') {
                                // Sort prices_by_weight so that the default price comes first
                                row.prices_by_weight.sort((a, b) => {
                                    if (a.default === 1) return -1;
                                    if (b.default === 1) return 1;
                                    return 0;
                                });

                                priceContent = '<div style="display: flex; align-items: center; width: 100%;">';
                                priceContent += '<span style="white-space: nowrap;">By weight:</span>';
                                priceContent += `<select class="price-select form-select form-control" data-product-id="${row.id}" style="flex-grow: 1; margin-left: 5px;">`;
                                row.prices_by_weight.forEach(function(price) {
                                    let optionText = `${price.unit} - `;
                                    if (price.effective_price !== price.price) {
                                        optionText += `${formatCurrency(price.effective_price)} (Old: ${formatCurrency(price.price)})`;
                                    } else {
                                        optionText += `${formatCurrency(price.price)}`;
                                    }
                                    if (row.qty && row.qty > 0) {
                                        optionText += ` (${row.qty} qty)`;
                                    }else{
                                        optionText += ` (Out of stock)`;
                                    }
                                    priceContent += `<option value="${price.price_id}">${optionText}</option>`;
                                });
                                priceContent += '</select></div>';
                            } else {
                                priceContent = 'By unit: ';
                                if (row.effective_price !== row.price) {
                                    priceContent += `${formatCurrency(row.effective_price)} <del>${formatCurrency(row.price)}</del>`;
                                } else {
                                    priceContent += `${formatCurrency(row.price)}`;
                                }
                                if (row.qty && row.qty > 0) {
                                    priceContent += ` (${row.qty} qty)`;
                                }else{
                                    priceContent += ` (Out of stock)`;
                                }
                            }
                            return priceContent;
                        }
                    },
                    {
                        "data": "public", 
                        "name": 'public', 
                        "orderable": true, 
                        "sClass": "content-middel selectOff",
                        render: function (data, type, row, meta) {
                            let badgeClass = getBadgeClass(row.public);
                            return `
                                <div class="dropdown withoutHover">
                                    <button class="btn btn-sm dropdown-toggle badge ${badgeClass}" type="button" id="dropdownMenuButton${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        ${row.public == 1 ? 'Published' : 'Unpublished'}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
                                        <a class="dropdown-item status-change" href="#" data-product-id="${row.id}" data-current-status="${row.public}" data-new-status="1">Published</a>
                                        <a class="dropdown-item status-change" href="#" data-product-id="${row.id}" data-current-status="${row.public}" data-new-status="0">Unpublished</a>
                                    </div>
                                </div>`;
                        }
                    },
                    { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel selectOff",
	            	    render: function ( data, type, row, meta) {
	            	    return '<a href="javascript:;" edit_item_id="'+row.id+'" class="item_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
	                }},
                ],
                "columnDefs": [
                    {"visible": false, "targets": 0},
                    {"width": "30%", "targets": 1},
                    {"width": "40%", "targets": 2},
                    {"width": "10%", "targets": 3},
                    {"width": "10%", "targets": 4},
                ],
                "lengthMenu": [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, "All"] // change per page values here
                ],
                "order": [
                    ['0', "desc"]
                ]
            });

            window.datatable = dataTable;

            $('#filter_status, #filter_category').change(function(){
                dataTable.draw();
            });

            $('#dataTable tbody').on('click', 'tbody tr td:not(.selectOff)', function (e) {
                $(this).parent('tr').toggleClass('selected');
            });

            $("[name='dataTable_length']").change(function(){
                var info = dataTable.page.info();
                var filter_category = $('#filter_category').val();
                
                if(info.length == "-1" && filter_category > 0){
                    $( "#dataTable" ).sortable( "enable" );
                }else{
                    $( "#dataTable" ).sortable( "disable" );
                }
                dataTable.draw();
            });

            var itemPopup = new Popup;
            itemPopup.init({
                size:'modal-xl',
                identifier:'edit-item',
                class: 'modal close-tiny',//close-tiny
                minHeight: '200',
            })
            window.itemPopup = itemPopup;

            $('#dataTable').on('click', '.item_edit', function (e) {
                editId = $(this).attr('edit_item_id');
                itemPopup.setTitle('Edit product');
                itemPopup.load("{{route('productGet')}}?id="+editId, function () {
                    this.open();
                });
            });

            $('#add_item').on('click', function (e) {
                Loading.add($('#add_item'));
                itemPopup.setTitle('Add product');
                itemPopup.load("{{route('productGet')}}", function () {
                    this.open();
                });
            });

            $('#on_off').on('click',function (){
                dataTable.draw();
            });
            


            $('#dataTable tbody').on('click', 'tr td:not(.selectOff)', function (e) {
                $(this).parent('tr').toggleClass('selected');
            });

            $("#remove_item").on('click', function (e) {
                if(dataTable.rows('.selected').data().length <= 0){
                    toastr['info']("Please select item", 'Information');
                }else{
                    var rows = [];
                    dataTable.rows('.selected').data().each(function (row) {
                        rows.push(row.id);
                    })
                    if(rows.length <= 0){
                        toastr['info']("Please select item", 'Information');
                        return
                    }
                    bootbox.confirm("Are you sure?", function(result) {
                        if(result){
                            $.ajax({
                            type: "POST",
                            url: "{{route('productRemove')}}",
                            dataType: 'JSON',
                            data:{_token: "<?php echo csrf_token(); ?>", ids:rows},
                                success: function(response){
                                    if(response.status == 1){
                                        datatable.ajax.reload(null, false);
                                    }else{
                                        toastr['error'](response.message, 'Error');
                                    }
                                }
                            });
                        }
                    });
                }
            });

            $("#filter_category").change(changeDataTable)
            $("[name='dataTable_length']").change(changeDataTable);

            $(document).on('click', '.status-change', function(e) {
                e.preventDefault();
                let productId = $(this).data('product-id');
                let newStatus = $(this).data('new-status');
                let currentStatus =  $(this).data('current-status');
                let button = $(`#dropdownMenuButton${productId}`);
                
                console.log(productId, newStatus, currentStatus);
                if (newStatus !== currentStatus) {
                    let newBadgeClass = getBadgeClass(newStatus);
                    Loading.add(button);

                    const formData = new FormData();
                    formData.append("_token", "{{ csrf_token()}}");
                    formData.append("id", productId);
                    formData.append("status", newStatus);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('productChangeStatus') }}",
                        data: formData,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == 0) {
                                toastr['error'](response.message, 'Error');
                            }
                            if (response.status == 1) {
                                buttonText = newStatus == 1 ? 'Published' : 'Unpublished';
                                button.text(capitalize(buttonText.replace("_", " ")));
                                button.removeClass('badge-info badge-success');
                                button.addClass(newBadgeClass);
                                window.datatable.ajax.reload(null, false);
                                toastr['success'](response.message, 'Success');
                            }
                            Loading.remove(button);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr['error'](errorThrown, 'Error');
                            Loading.remove(button);
                        }
                    });
                }
            });
            function getBadgeClass(status) {
                switch(status) {
                    case 1:
                        return 'badge-success';
                    case 0:
                        return 'badge-info';
                    default:
                        return 'badge-secondary';
                }
            }
            
            function changeDataTable(){
                var info = dataTable.page.info();
                var collection = $('#filter_category').val();
                
                if(info.length == "-1" && collection !== "" && collection !== "-1"){
                    $( "#dataTable" ).sortable( "enable" );
                }else{
                    $( "#dataTable" ).sortable( "disable" );
                }
                dataTable.draw();
            }
        });
    </script>
@endpush
@endsection
