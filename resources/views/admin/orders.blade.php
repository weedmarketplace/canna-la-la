@extends('admin.layouts.app')
@section('content')
<main>
    <input type="hidden" id="selected_user_id">
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="dollar-sign"></i></div>
                        Orders
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="col-12 col-xl-auto float-left">
                    <div class="d-flex">
                        <div class="custom-control custom-switch mt-n2">
                            <input class="custom-control-input" id="on_off" type="checkbox" @if(!$page) checked @endif  >
                            <label class="custom-control-label" for="on_off"  @if($page) checked @endif ></label>
                        </div>
                        <div class="small text-muted">Date range</div>
                    </div>
                    <button class="btn btn-white p-3" id="reportrange">
                        <i class="mr-2 text-primary" data-feather="calendar"></i>
                        <span></span>
                        <i class="ml-1" data-feather="chevron-down"></i>
                    </button>
                </div>
                <div class="form-group col-md-2 float-right p-0 ml-3">
                    <div class="small text-muted">Status</div>
                    <select class="form-control" name="filter_status" id="filter_status">
                        <option value=''>-- All--</option>
                        <option value='shipping' @if($page && $page == 'shipping') selected @endif>Shipping</option>
                        <option value='success' @if($page && $page == 'success') selected @endif>Success</option>
                        <option value='canceled' @if($page && $page == 'canceled') selected @endif>Canceled</option>
                        <option value='processing' @if($page && $page == 'processing') selected @endif>Processing</option>
                    </select>
                </div>
                <div class="form-group col-md-2 float-right p-0 autocomplete-container">
                    <div class="small text-muted">Users</div>
                    <input type="text" class="form-control" id="autocomplete" placeholder="Type to search...">
                    <span id="clearSelection" style="">&times;</span>
                    <div id="autocomplete-list" class="autocomplete-items"></div>
                </div>
                <!-- <button id="clearSelection">Clear Selection</button> -->
                <div class="table-responsive">
                        <table class="table table-bordered table-hover " id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>SKU</th>
                                <th>Fullname</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>SKU</th>
                                <th>Fullname</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Total</th>
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
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $("#autocomplete").on("input", function(){
                var query = $(this).val();

                $.ajax({
                    url: "{{route('aGetUsers')}}", // Your backend route
                    type: "GET",
                    data: { term: query },
                    success: function(data) {
                        $("#autocomplete-list").empty();

                        // Append new results
                        data.forEach(function(item) {
                            // Include user ID in the appended div
                            $("#autocomplete-list").append("<div data-userid='" + item.id + "'>" + item.name + "</div>");
                        });
                    }
                });
            });
            

            //Client autocomplete
            $(document).on("click", "#autocomplete-list div", function(){
                var userId = $(this).data("userid");
                var userName = $(this).text();

                $("#autocomplete").prop('readonly', true);
                $("#clearSelection").show();

                $("#autocomplete").val(userName);
                $("#selected_user_id").val(userId);
                $("#autocomplete-list").empty();

                dataTable.draw();
            });

            $(document).on("click", "#autocomplete-list div", function(){
                $("#autocomplete").val($(this).text());
                $("#autocomplete-list").empty();
            });
            
            $("#clearSelection").click(function() {
                $("#autocomplete").val('').prop('readonly', false);
                $("#selected_user_id").val('');
                $("#clearSelection").hide();
                // Redraw dataTable
                dataTable.draw();
            });
            ////////////////

            var start = moment();//.subtract(29, "days");
            var end = moment();

            function cb(start, end) {
                $("#reportrange span").html(
                    start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
                );
            }

            var picker =  $("#reportrange").daterangepicker(
                {
                    onSelect: function() {
                        // start = this.startDate
                        // end = this.endDate
                        // $(this).change();
                    },
                    startDate: start,
                    endDate: end,
                    ranges: {
                        Today: [moment(), moment()],
                        Yesterday: [
                            moment().subtract(1, "days"),
                            moment().subtract(1, "days"),
                        ],
                        "Last 7 Days": [moment().subtract(6, "days"), moment()],
                        "Last 30 Days": [moment().subtract(29, "days"), moment()],
                        "This Month": [
                            moment().startOf("month"),
                            moment().endOf("month"),
                        ],
                        "Last Month": [
                            moment().subtract(1, "month").startOf("month"),
                            moment().subtract(1, "month").endOf("month"),
                        ],
                    },
                },
                cb
            );

            cb(start, end);

            const capitalize = (s) => {
                if (typeof s !== 'string') return ''
                return s.charAt(0).toUpperCase() + s.slice(1)
            }

            var dataTable =  $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                'searching': true,
                "ajax": {
                    "url": "{{ route('orderData') }}",
                    "data": function(data){
                        data['sort_field'] = data.columns[data.order[0].column].name;
                        data['sort_dir'] =  data.order[0].dir;
                        data['search'] = data.search.value;

                        delete data.columns;
                        delete data.order;

                        var filter_status = $('#filter_status').val();
                        data.filter_status = filter_status;
                        
                        var filter_user = $('#selected_user_id').val();
                        data.filter_user = filter_user;
                        
                        if( $('#on_off').is(':checked') ){
                            data.start_date = picker.data('daterangepicker').startDate.format("YYYY-MM-DD");
                            data.end_date = picker.data('daterangepicker').endDate.format("YYYY-MM-DD");
                        }
                    }
                },
                "fnDrawCallback": function( oSettings ) {
                    feather.replace();
                    $('[data-toggle="popover"]').popover();
                },
                "columns": [
                    { "data": 'created_at', 'name': 'orders.created_at',"orderable": true},
                    { "data": 'sku', 'name': 'orders.sku',"orderable": true},
                    { "data": "fullname", "name":'fullname', "orderable": true },
                    { "data": "address", "name":'address', "orderable": true },
                    { "data": "phone", "name":'phone', "orderable": true },
                    { "data": "total", "name":'total', "orderable": true, render : function ( data, type, row, meta) {return formatCurrency(row.total)}},
                    {
                        "data": "status", 
                        "name": 'status', 
                        "orderable": true, 
                        "sClass": "content-middel",
                        render: function (data, type, row, meta) {
                            let badgeClass = getBadgeClass(row.status);
                            title = row.status == 'success' ? 'Delivered' : capitalize(row.status.replace("_", " "));
                            return `
                                <div class="dropdown withoutHover">
                                    <button class="btn btn-sm dropdown-toggle badge ${badgeClass}" type="button" id="dropdownMenuButton${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        ${title}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
                                        <a class="dropdown-item status-change" href="#" data-order-id="${row.id}" data-current-status="${row.status}" data-new-status="processing">Processing</a>
                                        <a class="dropdown-item status-change" href="#" data-order-id="${row.id}" data-current-status="${row.status}" data-new-status="shipping">Shipping</a>
                                        <a class="dropdown-item status-change" href="#" data-order-id="${row.id}" data-current-status="${row.status}" data-new-status="success">Delivered</a>
                                        <a class="dropdown-item status-change" href="#" data-order-id="${row.id}" data-current-status="${row.status}" data-new-status="canceled">Canceled</a>
                                    </div>
                                </div>`;
                        }
                    },
                    { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel", 
	            	    render: function ( data, type, row, meta) {
	            	    return '<a href="javascript:;" edit_item_id="'+row.id+'" class="item_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
	                }},
                ],
                "columnDefs": [
                    {"width": "10%", "targets": 0},
                    {"width": "15%", "targets": 1},
                    {"width": "15%", "targets": 2},
                    {"width": "15%", "targets": 3},
                    {"width": "15%", "targets": 4},
                    {"width": "10%", "targets": 5},
                    {"width": "10%", "targets": 6},
                    {"width": "10%", "targets": 7},
                ],
                "order": [
                    ['1', "desc"]
                ]
            });

            window.datatable = dataTable;  
            
            $('#filter_status').change(function(){
                dataTable.draw();
            });

            $('#reportrange').on('apply.daterangepicker', (e, picker) => {
                dataTable.draw();
            });
            

            var itemPopup = new Popup;
            itemPopup.init({
                size:'modal-xl',
                identifier:'edit-item',
                class: 'modal',
                minHeight: '200',
            })
            window.itemPopup = itemPopup;

            $('#on_off').on('click',function (){
                if( $('#on_off').is(':checked') ){
                    $('#reportrange').prop( "disabled", false );
                }
                else{
                    $('#reportrange').prop( "disabled", true );
                }
                dataTable.draw();
            });

            $('#dataTable').on('click', '.item_edit', function (e) {
                editId = $(this).attr('edit_item_id');
                itemPopup.setTitle('Order');
                itemPopup.load("{{route('aGetOrder')}}?id="+editId, function () {
                    this.open();
                });
            });
            $(document).on('click', '.status-change', function(e) {
                e.preventDefault();
                let orderId = $(this).data('order-id');
                let newStatus = $(this).data('new-status');
                let currentStatus =  $(this).data('current-status');
                let button = $(`#dropdownMenuButton${orderId}`);
                
                if (newStatus !== currentStatus) {
                    let newBadgeClass = getBadgeClass(newStatus);

                    title = newStatus == 'success' ? 'Delivered' : capitalize(newStatus.replace("_", " "));
                    button.text(title);
                    button.removeClass('badge-warning badge-info badge-success badge-danger');
                    button.addClass(newBadgeClass);
                    Loading.add(button);

                    const formData = new FormData();
                    formData.append("_token", "{{ csrf_token()}}");
                    formData.append("id", orderId);
                    formData.append("status", newStatus);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('aOrderChangeStatus') }}",
                        data: formData,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == 0) {
                                toastr['error'](response.message, 'Error');
                            }
                            if (response.status == 1) {
                                window.datatable.ajax.reload(null, false);
                                toastr['success'](response.message, 'Success');
                            }
                            Loading.remove(button);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if(jqXHR.responseText && jqXHR.responseText.message){
                                toastr['error'](jqXHR.responseText.message, 'Error');
                            }else{
                                toastr['error'](errorThrown, 'Error');
                            }
                            Loading.remove(button);
                        }
                    });
                }
            });
            function getBadgeClass(status) {
                switch(status) {
                    case 'shipping':
                        return 'badge-warning';
                    case 'processing':
                        return 'badge-info';
                    case 'success':
                        return 'badge-success';
                    case 'canceled':
                        return 'badge-danger';
                    default:
                        return 'badge-secondary';
                }
            }
        });
    </script>
@endpush
@endsection