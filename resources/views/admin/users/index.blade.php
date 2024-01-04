@extends('admin.layouts.app')
@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="users"></i></div>
                        Users
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover"  id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Fullname</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Registerd</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Fullname</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Registerd</th>
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
            const capitalize = (s) => {
                if (typeof s !== 'string') return ''
                return s.charAt(0).toUpperCase() + s.slice(1)
            }
            var dataTable =  $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                'searching': true,
                "ajax": {
                    "url": "{{ route('aUserData') }}",
                    "data": function(data){
                        data['sort_field'] = data.columns[data.order[0].column].name;
                        data['sort_dir'] =  data.order[0].dir;
                        data['search'] = data.search.value;

                        delete data.columns;
                        delete data.order;

                        var filter_status = $('#filter_status').val();
                        data.filter_status = filter_status;

                        var filter_verification = $('#filter_verification').val();
                        data.filter_verification = filter_verification;
                    }
                },
                "fnDrawCallback": function( oSettings ) {
                    feather.replace();
                    $('[data-toggle="popover"]').popover();
                },
                "columns": [
                    { "data": "id", "name":'id', "orderable": true },
                    { "data": "name", "name":'name', "orderable": true },
                    { "data": "phone", "name":'phone', "orderable": true },
                    { "data": "email", "name":'email', "orderable": true },
                    { "data": "created_at", "name":'created_at', "orderable": false, "sClass": "content-middel",
	            	    render: function ( data, type, row, meta) {
	            	    return row.created_at.split(' ')[0];
	                }},
                    { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel",
	            	    render: function ( data, type, row, meta) {
	            	    return '<a href="javascript:;" edit_item_id="'+row.id+'" class="item_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
	                }},
                ],
                "columnDefs": [
                    {"width": "10%", "targets": 0},
                    {"width": "30%", "targets": 1},
                    {"width": "30%", "targets": 2},
                    {"width": "10%", "targets": 3},
                    {"width": "20%", "targets": 4},
                    {"width": "10%", "targets": 5},
                    // {"width": "5%", "targets": 6},
                ],
                "order": [
                    ['0', "desc"]
                ]
            });

            window.datatable = dataTable;
            $('#filter_status').change(function(){
                dataTable.draw();
            });
            $('#filter_verification').change(function(){
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
            $('#dataTable').on('click', '.item_edit', function (e) {
                editId = $(this).attr('edit_item_id');
                itemPopup.setTitle('Edit Users');
                itemPopup.load("{{route('userGet')}}?id="+ editId, function () {
                    this.open();
                });
            });
        });
    </script>
@endpush
@endsection
